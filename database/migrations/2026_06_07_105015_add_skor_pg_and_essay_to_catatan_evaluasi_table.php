<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('catatan_evaluasi', function (Blueprint $table) {
            $table->integer('skor_pg')->nullable()->after('skor');
            $table->integer('skor_essay')->nullable()->after('skor_pg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_evaluasi', function (Blueprint $table) {
            $table->dropColumn(['skor_pg', 'skor_essay']);
        });
    }
};
