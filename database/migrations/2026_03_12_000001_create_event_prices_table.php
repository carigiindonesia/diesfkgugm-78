<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_prices', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // alumni, civitas, umum
            $table->string('event_code'); // simposium, handson, funrun, pengmas
            $table->string('event_label');
            $table->boolean('is_bundle')->default(false);
            $table->string('bundle_code')->nullable();
            $table->string('bundle_label')->nullable();
            $table->json('bundle_events')->nullable();
            $table->unsignedInteger('base_price');
            $table->unsignedInteger('display_price');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category', 'event_code', 'is_bundle', 'bundle_code'], 'unique_price_entry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_prices');
    }
};
