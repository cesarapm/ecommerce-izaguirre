<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrdenClienteAprobada;
use App\Mail\OrdenAprobada;
use App\Models\Order;
use App\Models\Pay;
use App\Services\MercadoPagoConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Webhook de Mercado Pago recibido', $request->all());

        if (!$this->validateWebhookSignature($request)) {
            return response()->json(['success' => false, 'message' => 'Firma inválida'], 401);
        }

        $type = $request->input('type');
        $paymentId = $request->input('data.id') ?? $request->input('id');
        $merchantOrderId = $request->input('data.id') ?? $request->input('data_id');

        if ($type === 'payment' && $paymentId) {
            $this->syncPayment((string) $paymentId);
        } elseif (in_array($type, ['merchant_order', 'topic_merchant_order_wh'], true) && $merchantOrderId) {
            $this->syncMerchantOrder((string) $merchantOrderId);
        }

        return response()->json(['success' => true]);
    }

    protected function validateWebhookSignature(Request $request): bool
    {
        $secret = MercadoPagoConfig::getWebhookSecret();

        if (!$secret) {
            return true;
        }

        $xSignature = $request->header('x-signature');
        $xRequestId = $request->header('x-request-id');

        if (!$xSignature || !$xRequestId) {
            return false;
        }

        $signatureParts = [];
        foreach (explode(',', $xSignature) as $part) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, null);
            if ($key && $value) {
                $signatureParts[trim($key)] = trim($value);
            }
        }

        $timestamp = $signatureParts['ts'] ?? null;
        $receivedHash = $signatureParts['v1'] ?? null;
        $dataId = $request->input('data.id') ?? $request->input('data_id') ?? $request->input('id');

        if (!$timestamp || !$receivedHash || !$dataId) {
            return false;
        }

        $manifest = "id:{$dataId};request-id:{$xRequestId};ts:{$timestamp};";
        $calculatedHash = hash_hmac('sha256', $manifest, $secret);

        return hash_equals($calculatedHash, $receivedHash);
    }

    protected function syncMerchantOrder(string $merchantOrderId): void
    {
        $accessToken = MercadoPagoConfig::getAccessToken();

        if (!$accessToken) {
            Log::warning('Mercado Pago no configurado para merchant order');
            return;
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->get("https://api.mercadopago.com/merchant_orders/{$merchantOrderId}");

        if (!$response->successful()) {
            Log::error('No se pudo consultar merchant order', [
                'merchant_order_id' => $merchantOrderId,
                'response' => $response->json(),
            ]);
            return;
        }

        foreach ($response->json('payments', []) as $payment) {
            if (!empty($payment['id'])) {
                $this->syncPayment((string) $payment['id']);
            }
        }
    }

    protected function syncPayment(string $paymentId): void
    {
        $accessToken = MercadoPagoConfig::getAccessToken();

        if (!$accessToken) {
            Log::warning('Mercado Pago no configurado para sincronizar pagos');
            return;
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        if (!$response->successful()) {
            Log::error('No se pudo consultar el pago en Mercado Pago', [
                'payment_id' => $paymentId,
                'response' => $response->json(),
            ]);
            return;
        }

        $payment = $response->json();
        $order = Order::find($payment['external_reference'] ?? null);

        if (!$order) {
            Log::warning('Pago recibido sin orden asociada', [
                'payment_id' => $paymentId,
                'external_reference' => $payment['external_reference'] ?? null,
            ]);
            return;
        }

        $existingPay = Pay::where('id_pago', (string) $payment['id'])->first();
        $previousStatus = $existingPay?->estado;

        $pay = Pay::updateOrCreate(
            ['id_pago' => (string) $payment['id']],
            [
                'order_id' => $order->id,
                'payment_id' => $payment['external_reference'] ?? null,
                'descripcion' => $payment['description'] ?? $order->order_number,
                'monto_transaccion' => $payment['transaction_amount'] ?? 0,
                'monto_recibido_neto' => $payment['transaction_details']['net_received_amount'] ?? 0,
                'monto_a_pagar' => $payment['transaction_amount'] ?? 0,
                'codigo_autorizacion' => $payment['authorization_code'] ?? null,
                'estado' => $payment['status'] ?? null,
                'fecha_aprobacion' => $payment['date_approved'] ?? null,
                'fecha_creacion' => $payment['date_created'] ?? now()->toDateTimeString(),
                'fecha_ultima_actualizacion' => $payment['date_last_updated'] ?? null,
                'metodo_pago' => $payment['payment_method_id'] ?? $payment['payment_method']['id'] ?? null,
                'numero_tarjeta' => isset($payment['card']['first_six_digits'], $payment['card']['last_four_digits'])
                    ? $payment['card']['first_six_digits'] . '******' . $payment['card']['last_four_digits']
                    : null,
                'ip_direccion' => $payment['additional_info']['ip_address'] ?? null,
                'url_notificacion' => $payment['notification_url'] ?? null,
            ]
        );

        $currentStatus = $payment['status'] ?? null;

        $order->update([
            'status' => $this->mapPaymentStatus($currentStatus),
            'payment_id' => (string) $payment['id'],
            'metodo_pago' => 'mercado_pago',
        ]);

        if ($currentStatus === 'approved' && $previousStatus !== 'approved') {
            $this->sendApprovedOrderMail($order->fresh('items'), $pay);
        }
    }

    protected function sendApprovedOrderMail(Order $order, Pay $pay): void
    {
        $adminEmail = config('mail.admin_email') ?: config('mail.from.address');

        if (!$adminEmail) {
            Log::warning('No hay correo configurado para notificar orden aprobada', [
                'order_id' => $order->id,
                'payment_id' => $pay->id_pago,
            ]);
        } else {
            $this->deliverApprovedOrderMail(
                $adminEmail,
                new OrdenAprobada($order, $pay),
                'Correo de orden aprobada enviado',
                'No se pudo enviar el correo de orden aprobada',
                $order,
                $pay,
            );
        }

        if ($order->customer_email) {
            $this->deliverApprovedOrderMail(
                $order->customer_email,
                new OrdenClienteAprobada($order, $pay),
                'Correo de confirmacion de pedido enviado al cliente',
                'No se pudo enviar el correo de confirmacion al cliente',
                $order,
                $pay,
            );
        }
    }

    protected function deliverApprovedOrderMail(
        string $recipient,
        mixed $mailable,
        string $successMessage,
        string $errorMessage,
        Order $order,
        Pay $pay,
    ): void {
        try {
            Mail::to($recipient)->send($mailable);

            Log::info($successMessage, [
                'order_id' => $order->id,
                'payment_id' => $pay->id_pago,
                'recipient' => $recipient,
            ]);
        } catch (\Throwable $exception) {
            Log::error($errorMessage, [
                'order_id' => $order->id,
                'payment_id' => $pay->id_pago,
                'recipient' => $recipient,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    protected function mapPaymentStatus(?string $status): string
    {
        return match ($status) {
            'approved' => 'aprobado',
            'pending', 'in_process' => 'pendiente',
            'rejected', 'cancelled', 'refunded', 'charged_back' => 'rechazado',
            default => 'pendiente',
        };
    }
}
