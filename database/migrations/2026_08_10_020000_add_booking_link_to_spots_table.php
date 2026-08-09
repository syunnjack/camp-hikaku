<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            // Real, curl-verified affiliate URL to the property's booking page (nullable — only set when a real listing exists).
            $table->string('booking_url', 1000)->nullable()->after('tags');
            // 'rakuten' or 'ikyu' — which provider the booking_url points to.
            $table->string('booking_provider')->nullable()->after('booking_url');
        });
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn(['booking_url', 'booking_provider']);
        });
    }
};
