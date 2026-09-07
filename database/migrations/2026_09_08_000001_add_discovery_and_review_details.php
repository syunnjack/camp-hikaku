<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->string('official_url', 1000)->nullable();
            $table->index(['category', 'area']);
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->date('visited_on')->nullable();
            $table->string('party', 20)->nullable();
            $table->unsignedInteger('cost')->nullable();
            $table->boolean('is_hidden')->default(false)->index();
        });
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->string('reason', 30);
            $table->string('ip_hash', 64);
            $table->timestamps();
            $table->unique(['review_id', 'ip_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_reports');
        Schema::table('reviews', fn (Blueprint $table) => $table->dropColumn(['visited_on', 'party', 'cost', 'is_hidden']));
        Schema::table('spots', function (Blueprint $table) {
            $table->dropIndex(['category', 'area']);
            $table->dropColumn('official_url');
        });
    }
};
