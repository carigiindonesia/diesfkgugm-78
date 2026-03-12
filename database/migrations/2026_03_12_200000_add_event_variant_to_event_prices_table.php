<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_prices', function (Blueprint $table) {
            $table->string('event_variant', 100)->nullable()->after('event_code');
            $table->text('event_description')->nullable()->after('event_label');

            $table->dropUnique('unique_price_entry');
            $table->unique(['category', 'event_code', 'event_variant', 'is_bundle', 'bundle_code'], 'unique_price_entry');
        });
    }

    public function down(): void
    {
        Schema::table('event_prices', function (Blueprint $table) {
            $table->dropUnique('unique_price_entry');
            $table->dropColumn(['event_variant', 'event_description']);
            $table->unique(['category', 'event_code', 'is_bundle', 'bundle_code'], 'unique_price_entry');
        });
    }
};
