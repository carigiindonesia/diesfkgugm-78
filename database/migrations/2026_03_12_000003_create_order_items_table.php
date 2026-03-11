<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('event_code');
            $table->string('event_label');
            $table->unsignedInteger('base_price');
            $table->unsignedInteger('display_price');
            $table->timestamps();

            $table->index(['order_id', 'event_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
