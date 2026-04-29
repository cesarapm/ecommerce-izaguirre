<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerOrderAccessController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderTrackingController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);



Route::post('/crear-pedido', [PedidoController::class, 'crearPedido']);
Route::post('/crear-pedido/transferencia', [PedidoController::class, 'crearPedidoTransferencia']);
Route::get('/pedidos/seguimiento', [OrderTrackingController::class, 'show']);
Route::post('/clientes/pedidos/acceso', [CustomerOrderAccessController::class, 'requestCode']);
Route::post('/clientes/pedidos/verificar', [CustomerOrderAccessController::class, 'verifyCode']);

Route::delete('/ordenes/{id}', [PedidoController::class, 'ordenescancelar']);

// ⚠️ Webhook de Mercado Pago - DEBE estar fuera del middleware de autenticación
Route::post('/mercado-pago/webhook', [WebhookController::class, 'handleWebhook']);

// Ruta pública para cancelar orden cuando el pago falla
Route::post('/cancelar-orden-pago-fallido', [PedidoController::class, 'cancelarOrdenPorPagoFallido']);
