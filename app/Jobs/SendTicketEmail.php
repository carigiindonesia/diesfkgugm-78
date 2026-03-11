<?php

namespace App\Jobs;

use App\Mail\TicketConfirmation;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTicketEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        Mail::to($this->order->email)
            ->send(new TicketConfirmation($this->order));

        $this->order->update(['email_sent' => true]);
    }
}
