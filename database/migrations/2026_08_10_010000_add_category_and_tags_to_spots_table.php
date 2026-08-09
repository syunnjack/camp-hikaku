<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            // 'campground' (default, existing UGC data) or 'glamping'
            $table->string('category')->nullable()->after('area');
            // Editorial audience tags, e.g. ["family","couple","friends","solo"]
            $table->json('tags')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn(['category', 'tags']);
        });
    }
};
