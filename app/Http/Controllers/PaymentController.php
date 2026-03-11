<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        $order->load('items', 'tickets');

        return view('pages.pembayaran', compact('order'));
    }
}
