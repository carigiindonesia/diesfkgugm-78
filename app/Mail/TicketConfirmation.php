<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tiket Anda - Dies Natalis FKG UGM ke-78 [{$this->order->order_number}]",
        );
    }

    public function content(): Content
    {
        $this->order->load('tickets');

        return new Content(
            view: 'emails.ticket-confirmation',
            with: [
                'order' => $this->order,
                'ticketLinks' => $this->order->tickets->map(fn ($t) => [
                    'label' => $t->event_label,
                    'code' => $t->ticket_code,
                    'url' => route('tiket.show', $t->ticket_code),
                ]),
            ],
        );
    }
}
