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
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->unsignedBigInteger('id_modul');
            $table->string('judul');
            $table->string('bahasa')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->string('tipe');
            $table->json('panduan')->nullable();
            $table->timestamps();

            $table->foreign('id_modul')->references('id_modul')->on('modul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
