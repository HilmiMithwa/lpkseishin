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
            $table->json('jawaban_siswa')->nullable()->after('skor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_evaluasi', function (Blueprint $table) {
            $table->dropColumn('jawaban_siswa');
        });
    }
};
