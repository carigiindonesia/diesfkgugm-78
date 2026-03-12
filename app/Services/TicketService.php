<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Ticket;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketService
{
    public function generateTickets(Order $order): void
    {
        $order->load('items');

        foreach ($order->items as $item) {
            $ticketCode = Ticket::generateCode($item->event_code, $order->category);

            Ticket::create([
                'order_id' => $order->id,
                'order_item_id' => $item->id,
                'ticket_code' => $ticketCode,
                'event_code' => $item->event_code,
                'event_label' => $item->event_label,
                'participant_name' => $item->participant_name ?? $order->nama_lengkap,
                'participant_lembaga' => $item->participant_lembaga ?? $order->lembaga,
                'category' => $order->category,
            ]);
        }
    }

    public function generateBarcode(string $code): string
    {
        $generator = new BarcodeGeneratorSVG;

        return $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 60);
    }

    public function generateQrCode(Ticket $ticket): string
    {
        $verifyUrl = route('tiket.verify', $ticket->ticket_code);

        return QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($verifyUrl);
    }

    public function generateBarcodeForPdf(string $code): string
    {
        $generator = new BarcodeGeneratorPNG;
        $png = $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 60);
        $base64 = base64_encode($png);

        return '<img src="data:image/png;base64,'.$base64.'" style="max-width:200px;height:50px;">';
    }

    public function generateQrCodeForPdf(string $url): string
    {
        $svg = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($url);
        $base64 = base64_encode($svg);

        return '<img src="data:image/svg+xml;base64,'.$base64.'" style="width:100px;height:100px;">';
    }
}
