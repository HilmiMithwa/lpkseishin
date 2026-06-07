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
        Schema::create('evaluasi_questions', function (Blueprint $table) {
            $table->id('id_soal');
            $table->unsignedBigInteger('id_evaluasi');
            $table->string('tipe_soal'); // 'mcq' or 'essay'
            $table->text('pertanyaan');
            $table->json('pilihan')->nullable(); // For MCQ options
            $table->string('kunci_jawaban')->nullable(); // '0', '1', '2', '3' or exact string
            $table->timestamps();

            $table->foreign('id_evaluasi')->references('id_evaluasi')->on('evaluasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_questions');
    }
};
