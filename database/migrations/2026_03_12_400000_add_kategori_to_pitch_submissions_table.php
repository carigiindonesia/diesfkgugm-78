<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pitch_submissions', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('lembaga');
        });
    }

    public function down(): void
    {
        Schema::table('pitch_submissions', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
