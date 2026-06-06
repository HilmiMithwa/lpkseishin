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
        Schema::create('catatan_evaluasi', function (Blueprint $table) {
            $table->id('id_catatan_evaluasi');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_mapel');
            $table->string('nama_evaluasi');
            $table->string('tipe_ujian')->nullable();
            $table->integer('skor')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_evaluasi');
    }
};
