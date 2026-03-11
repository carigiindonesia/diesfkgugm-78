<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        $ticket->load('order', 'orderItem');
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
        $barcode = $ticketService->generateBarcode($ticket->ticket_code);
        $qrCode = $ticketService->generateQrCode($ticket);

        return view('pages.tiket-download', compact('ticket', 'barcode', 'qrCode'));
    }
}
