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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id('id_tugas');
            $table->string('judul_tugas');
            $table->text('deskripsi_tugas');
            $table->datetime('waktu_pengumpulan');
            $table->string('status_tugas');
            $table->foreignId('id_rps')->constrained('rps','id_rps')->onDelete('cascade');
            $table->foreignId('id_modul')->constrained('modul', 'id_modul')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
