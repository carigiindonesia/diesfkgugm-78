<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('order_number')->unique();

            // Participant data
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->string('nama_satusehat')->nullable();
            $table->string('email_satusehat')->nullable();
            $table->string('email');
            $table->string('whatsapp_satusehat')->nullable();
            $table->string('whatsapp');
            $table->string('lembaga');
            $table->string('category'); // alumni, civitas, umum

            // Fun Run specific
            $table->string('jersey_type')->nullable(); // dewasa, anak
            $table->string('jersey_size')->nullable(); // S, M, L, XL, XXL, XXXL

            // Pricing
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('fee_amount');
            $table->unsignedInteger('total_amount');

            // Payment
            $table->string('status')->default('pending');
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_invoice_url')->nullable();
            $table->string('xendit_payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            // Flags
            $table->boolean('is_bundle')->default(false);
            $table->string('bundle_code')->nullable();
            $table->boolean('email_sent')->default(false);

            $table->timestamps();

            $table->index('status');
            $table->index('email');
            $table->index('xendit_invoice_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
