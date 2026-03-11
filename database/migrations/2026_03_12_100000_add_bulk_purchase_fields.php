<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedTinyInteger('quantity')->default(1)->after('category');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('participant_name')->nullable()->after('display_price');
            $table->date('participant_tanggal_lahir')->nullable()->after('participant_name');
            $table->string('participant_lembaga')->nullable()->after('participant_tanggal_lahir');
            $table->string('participant_nama_satusehat')->nullable()->after('participant_lembaga');
            $table->string('participant_jersey_type')->nullable()->after('participant_nama_satusehat');
            $table->string('participant_jersey_size')->nullable()->after('participant_jersey_type');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'participant_name',
                'participant_tanggal_lahir',
                'participant_lembaga',
                'participant_nama_satusehat',
                'participant_jersey_type',
                'participant_jersey_size',
            ]);
        });
    }
};
