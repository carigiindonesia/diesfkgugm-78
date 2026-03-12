<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        $ticket->load('order.tickets', 'orderItem');
        abort_unless($ticket->order->isPaid(), 404);

        $ticketService = app(TicketService::class);
        $barcode = $ticketService->generateBarcode($ticket->ticket_code);
        $qrCode = $ticketService->generateQrCode($ticket);

        return view('pages.tiket', compact('ticket', 'barcode', 'qrCode'));
    }

    public function verify(Ticket $ticket)
    {
        $ticket->load('order');

        return response()->json([
            'valid' => $ticket->order->isPaid(),
            'ticket_code' => $ticket->ticket_code,
            'participant_name' => $ticket->participant_name,
            'event' => $ticket->event_label,
            'category' => $ticket->category,
            'lembaga' => $ticket->participant_lembaga,
            'checked_in' => $ticket->is_checked_in,
            'checked_in_at' => $ticket->checked_in_at?->toISOString(),
        ]);
    }

    public function download(Ticket $ticket)
    {
        $ticket->load('order', 'orderItem');
        abort_unless($ticket->order->isPaid(), 404);

        $ticketService = app(TicketService::class);
        $barcode = $ticketService->generateBarcodeForPdf($ticket->ticket_code);
        $verifyUrl = route('tiket.verify', $ticket->ticket_code);
        $qrCode = $ticketService->generateQrCodeForPdf($verifyUrl);

        $ticketsData = [
            $this->buildTicketData($ticket, $barcode, $qrCode),
        ];

        $pdf = Pdf::loadView('pages.tiket-pdf', ['ticketsData' => $ticketsData])
            ->setPaper('a5', 'portrait');

        return $pdf->download("tiket-{$ticket->ticket_code}.pdf");
    }

    public function downloadOrder(Order $order)
    {
        abort_unless($order->isPaid(), 404);

        $order->load('tickets.orderItem');
        $ticketService = app(TicketService::class);

        $ticketsData = [];
        foreach ($order->tickets as $ticket) {
            $barcode = $ticketService->generateBarcodeForPdf($ticket->ticket_code);
            $verifyUrl = route('tiket.verify', $ticket->ticket_code);
            $qrCode = $ticketService->generateQrCodeForPdf($verifyUrl);
            $ticketsData[] = $this->buildTicketData($ticket, $barcode, $qrCode);
        }

        $pdf = Pdf::loadView('pages.tiket-pdf', ['ticketsData' => $ticketsData])
            ->setPaper('a5', 'portrait');

        return $pdf->download("tiket-{$order->order_number}.pdf");
    }

    private function buildTicketData(Ticket $ticket, string $barcode, string $qrCode): array
    {
        $isFunRun = $ticket->event_code === 'funrun';

        return [
            'ticket' => $ticket,
            'barcode' => $barcode,
            'qrCode' => $qrCode,
            'isFunRun' => $isFunRun,
            'jerseyType' => $isFunRun ? $ticket->orderItem?->participant_jersey_type : null,
            'jerseySize' => $isFunRun ? $ticket->orderItem?->participant_jersey_size : null,
        ];
    }
}
