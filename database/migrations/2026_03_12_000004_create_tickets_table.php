<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->string('ticket_code')->unique();
            $table->string('event_code');
            $table->string('event_label');
            $table->string('participant_name');
            $table->string('participant_lembaga');
            $table->string('category');
            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->string('checked_in_by')->nullable();
            $table->timestamps();

            $table->index('event_code');
            $table->index('is_checked_in');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
