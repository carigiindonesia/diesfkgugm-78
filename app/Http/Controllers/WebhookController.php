<?php

namespace App\Http\Controllers;

use App\Jobs\SendTicketEmail;
use App\Models\Order;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleXendit(Request $request): JsonResponse
    {
        $callbackToken = $request->header('x-callback-token');
        if ($callbackToken !== config('services.xendit.callback_token')) {
            Log::warning('Xendit webhook: invalid callback token');

            return response()->json(['error' => 'Invalid token'], 403);
        }

        $data = $request->all();
        $xenditInvoiceId = $data['id'] ?? null;

        if (! $xenditInvoiceId) {
            return response()->json(['error' => 'Missing invoice ID'], 400);
        }

        $order = Order::where('xendit_invoice_id', $xenditInvoiceId)->first();

        if (! $order) {
            Log::warning("Xendit webhook: order not found for invoice {$xenditInvoiceId}");

            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($order->isPaid()) {
            return response()->json(['status' => 'already_processed']);
        }

        $status = strtolower($data['status'] ?? '');

        return $this->processWebhookStatus($order, $status, $data);
    }

    private function processWebhookStatus(Order $order, string $status, array $data): JsonResponse
    {
        if ($status === 'paid' || $status === 'settled') {
            $this->handlePaymentSuccess($order, $data);
        } elseif ($status === 'expired') {
            $order->update(['status' => 'expired']);
            Log::info("Xendit webhook: order {$order->order_number} expired");
        } elseif ($status === 'failed') {
            $order->update(['status' => 'failed']);
            Log::info("Xendit webhook: order {$order->order_number} failed");
        }

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentSuccess(Order $order, array $data): void
    {
        DB::transaction(function () use ($order, $data) {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'xendit_payment_method' => $data['payment_method'] ?? $data['payment_channel'] ?? null,
            ]);

            app(TicketService::class)->generateTickets($order);
        });

        SendTicketEmail::dispatch($order);

        Log::info("Xendit webhook: order {$order->order_number} paid");
    }
}
