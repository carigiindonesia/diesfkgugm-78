<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('url', 2048);
            $table->string('method', 10)->default('GET');
            $table->string('user_agent', 1024)->nullable();
            $table->string('referer', 2048)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->string('email')->nullable();
            $table->string('order_uuid')->nullable();
            $table->string('order_status')->nullable();
            $table->string('page_type', 50)->nullable();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('session_id');
            $table->index('page_type');
            $table->index('created_at');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
