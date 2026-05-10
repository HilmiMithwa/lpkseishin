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
        Schema::create('modul', function (Blueprint $table) {
            $table->id('id_modul');
            $table->string('nama_modul');
            $table->text('tujuan_pembelajaran');
            $table->text('materi_pembelajaran');
            $table->text('kegiatan_pembelajaran');
            $table->text('penilaian');
            $table->foreignId('id_mapel')->constrained('mapel', 'id_mapel')->onDelete('cascade');
            $table->foreignId('id_rps')->constrained('rps','id_rps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};
