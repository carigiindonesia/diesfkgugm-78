<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('emergency_contact_name')->nullable()->after('jersey_size');
            $table->string('emergency_contact_whatsapp', 20)->nullable()->after('emergency_contact_name');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('participant_emergency_contact_name')->nullable()->after('participant_jersey_size');
            $table->string('participant_emergency_contact_whatsapp', 20)->nullable()->after('participant_emergency_contact_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['emergency_contact_name', 'emergency_contact_whatsapp']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['participant_emergency_contact_name', 'participant_emergency_contact_whatsapp']);
        });
    }
};
