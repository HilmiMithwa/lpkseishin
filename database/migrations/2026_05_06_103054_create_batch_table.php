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
        Schema::create('batch', function (Blueprint $table) {
            $table->id('id_batch');
            $table->string('nama'); 
            $table->string('nama_program');
            $table->string('level_target');
            $table->string('deskripsi');
            $table->date('waktu_mulai');
            $table->date('waktu_berakhir');
            $table->string('durasi');
            $table->string('jadwal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch');
    }
};
