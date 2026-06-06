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
        Schema::create('evaluasi_question_images', function (Blueprint $table) {
            $table->id('id_gambar');
            $table->unsignedBigInteger('id_soal');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('id_soal')->references('id_soal')->on('evaluasi_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_question_images');
    }
};
