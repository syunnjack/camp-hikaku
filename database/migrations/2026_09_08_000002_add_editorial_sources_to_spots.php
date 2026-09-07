<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->date('source_checked_at')->nullable();
            $table->json('source_urls')->nullable();
            $table->string('location_note', 500)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('spots', fn (Blueprint $table) => $table->dropColumn(['address', 'source_checked_at', 'source_urls', 'location_note']));
    }
};
