<?php

namespace App\Services;

use App\Models\Order;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class XenditService
{
    private InvoiceApi $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
        $this->invoiceApi = new InvoiceApi();
    }

    public function createInvoice(Order $order): array
    {
        $items = $order->items->map(fn ($item) => [
            'name' => $item->event_label,
            'quantity' => 1,
            'price' => $item->display_price,
        ])->toArray();

        $request = new CreateInvoiceRequest([
            'external_id' => $order->order_number,
            'amount' => $order->total_amount,
            'payer_email' => $order->email,
            'description' => "Registrasi Dies Natalis FKG UGM ke-78 - {$order->order_number}",
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => $order->nama_lengkap,
                'email' => $order->email,
                'mobile_number' => $order->whatsapp,
            ],
            'success_redirect_url' => route('pembayaran.show', $order->uuid),
            'failure_redirect_url' => route('pembayaran.show', $order->uuid),
            'items' => $items,
            'currency' => 'IDR',
        ]);

        $result = $this->invoiceApi->createInvoice($request);

        return [
            'id' => $result->getId(),
            'invoice_url' => $result->getInvoiceUrl(),
        ];
    }
}
