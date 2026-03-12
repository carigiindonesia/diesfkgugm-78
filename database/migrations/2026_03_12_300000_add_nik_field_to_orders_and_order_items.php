<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('tanggal_lahir');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('participant_nik', 16)->nullable()->after('participant_tanggal_lahir');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('nik');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('participant_nik');
        });
    }
};
