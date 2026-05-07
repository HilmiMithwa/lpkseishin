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
        Schema::create('bahan_ajar', function (Blueprint $table) {
            $table->id('id_bahan_ajar');
            $table->string('nama_file');           
            $table->string('path_file');
            $table->integer('ukuran_file');
            $table->timestamp('unggah_file');
            $table->foreignId('id_rps')->constrained('rps','id_rps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_ajar');
    }
};
