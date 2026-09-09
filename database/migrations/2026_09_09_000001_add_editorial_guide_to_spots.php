<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', fn (Blueprint $table) => $table->string('editorial_guide')->nullable()->unique());
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropUnique(['editorial_guide']);
            $table->dropColumn('editorial_guide');
        });
    }
};
