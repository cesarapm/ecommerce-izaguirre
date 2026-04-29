<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    public function crearPedido(Request $request)
    {
        try {
            $validated = $this->validateCheckoutPayload($request);
            $order = $this->storeOrder($validated, 'mercado_pago', 'pendiente');
            $preference = $this->crearPreferenciaPago($order);

            if (!empty($preference['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo iniciar el pago con Mercado Pago.',
                ], 502);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden creada y lista para pagar.',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'status' => $order->status,
                ],
                'checkout_url' => $preference['init_point'] ?? $preference['sandbox_init_point'] ?? null,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            Log::error('Error al crear pedido con Mercado Pago', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el pedido.',
            ], 500);
        }
    }

    public function crearPedidoTransferencia(Request $request)
    {
        try {
            $validated = $this->validateCheckoutPayload($request);
            $order = $this->storeOrder($validated, 'transferencia', 'pendiente_transferencia');

            return response()->json([
                'success' => true,
                'message' => 'Orden creada con pago por transferencia.',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'status' => $order->status,
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            Log::error('Error al crear pedido por transferencia', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el pedido de transferencia.',
            ], 500);
        }
    }

    public function ordenescancelar($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update(['status' => 'cancelado']);

            return response()->json([
                'success' => true,
                'message' => 'Orden cancelada correctamente.',
            ]);
        } catch (\Throwable $exception) {
            Log::error('Error al cancelar orden', [
                'order_id' => $id,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo cancelar la orden.',
            ], 500);
        }
    }

    public function cancelarOrdenPorPagoFallido(Request $request)
    {
        $validated = $request->validate([
            'orden_id' => 'required|exists:orders,id',
        ]);

        try {
            $order = Order::findOrFail($validated['orden_id']);

            if (in_array($order->status, ['pendiente', 'pendiente_transferencia'], true)) {
                $order->update(['status' => 'cancelado']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizada tras pago fallido.',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                ],
            ]);
        } catch (\Throwable $exception) {
            Log::error('Error al cancelar orden por pago fallido', [
                'order_id' => $validated['orden_id'],
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la orden.',
            ], 500);
        }
    }

    private function validateCheckoutPayload(Request $request): array
    {
        return $request->validate([
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'save_customer_profile' => 'nullable|boolean',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ], [
            'customer_first_name.required' => 'El nombre es obligatorio.',
            'customer_last_name.required' => 'El apellido es obligatorio.',
            'customer_email.required' => 'El correo electrónico es obligatorio.',
            'customer_email.email' => 'Escribe un correo electrónico válido.',
            'customer_phone.required' => 'El teléfono es obligatorio.',
            'shipping_address.required' => 'La dirección de envío es obligatoria.',
            'shipping_city.required' => 'La ciudad es obligatoria.',
            'shipping_state.required' => 'El estado es obligatorio.',
            'shipping_zip_code.required' => 'El código postal es obligatorio.',
            'items.required' => 'Tu carrito está vacío.',
            'items.*.product_id.exists' => 'Uno de los productos ya no está disponible.',
        ]);
    }

    private function storeOrder(array $validated, string $paymentMethod, string $status): Order
    {
        return DB::transaction(function () use ($validated, $paymentMethod, $status) {
            $calculatedSubtotal = collect($validated['items'])
                ->sum(fn (array $item) => (float) $item['unit_price'] * (int) $item['quantity']);
            $shippingCost = (float) $validated['shipping_cost'];
            $tax = 0;
            $calculatedTotal = $calculatedSubtotal + $shippingCost + $tax;
            $customer = null;

            if (!empty($validated['save_customer_profile'])) {
                $customer = Customer::updateOrCreate(
                    ['email' => strtolower((string) $validated['customer_email'])],
                    [
                        'first_name' => $validated['customer_first_name'],
                        'last_name' => $validated['customer_last_name'],
                        'phone' => $validated['customer_phone'],
                        'address' => $validated['shipping_address'],
                        'city' => $validated['shipping_city'],
                        'state' => $validated['shipping_state'],
                        'zip_code' => $validated['shipping_zip_code'],
                        'last_ordered_at' => now(),
                    ]
                );
            }

            $order = Order::create([
                'customer_id' => $customer?->id,
                'customer_first_name' => $validated['customer_first_name'],
                'customer_last_name' => $validated['customer_last_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_zip_code' => $validated['shipping_zip_code'],
                'subtotal' => $calculatedSubtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $calculatedTotal,
                'metodo_pago' => $paymentMethod,
                'status' => $status,
                'notes' => $validated['notes'] ?? null,
                'envio' => [
                    'address' => $validated['shipping_address'],
                    'city' => $validated['shipping_city'],
                    'state' => $validated['shipping_state'],
                    'zip_code' => $validated['shipping_zip_code'],
                ],
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => (float) $item['unit_price'] * (int) $item['quantity'],
                ]);
            }

            return $order->fresh('items');
        });
    }

    private function crearPreferenciaPago(Order $order): array
    {
        $accessToken = config('services.mercadopago.access_token');

        if (!$accessToken) {
            return ['error' => 'Mercado Pago no está configurado'];
        }

        $frontendUrl = rtrim(config('app.frontend_url', config('app.url')), '/');
        $notificationUrl = config('services.mercadopago.notification_url') ?: url('/api/mercado-pago/webhook');

        $backUrls = [
            'success' => $frontendUrl . '/checkout/exito',
            'failure' => $frontendUrl . '/checkout/error',
            'pending' => $frontendUrl . '/checkout/pendiente',
        ];

        $payload = [
            'items' => $order->items->map(fn (OrderItem $item) => [
                'title' => $item->product_name,
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'currency_id' => 'MXN',
            ])->values()->all(),
            'external_reference' => (string) $order->id,
            'notification_url' => $notificationUrl,
            'back_urls' => $backUrls,
            'statement_descriptor' => 'IZAGUIRREQU',
        ];

        if (str_starts_with($backUrls['success'], 'https://')) {
            $payload['auto_return'] = 'approved';
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->timeout(30)
            ->post('https://api.mercadopago.com/checkout/preferences', $payload);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Mercado Pago rechazó la preferencia', [
            'order_id' => $order->id,
            'status' => $response->status(),
            'response' => $response->json(),
            'payload' => $payload,
        ]);

        return [
            'error' => $response->json('message') ?: 'Error al crear preferencia',
            'details' => $response->json(),
        ];
    }
}
