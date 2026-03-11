<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pitch_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('submission_number')->unique();
            $table->text('authors');
            $table->string('lembaga');
            $table->string('judul');
            $table->string('abstract_link');
            $table->string('video_link')->nullable();
            $table->string('status')->default('submitted'); // submitted, reviewing, accepted, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pitch_submissions');
    }
};
