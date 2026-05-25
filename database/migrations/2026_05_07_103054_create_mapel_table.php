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
        Schema::create('mapel', function (Blueprint $table) {
            $table->id('id_mapel');
            $table->foreignId('id_batch')->constrained('batch')->onDelete('cascade');
            $table->string('kode_mapel')->unique();
            $table->string('nama_mapel');
            $table->string('deskripsi_mapel');
            $table->foreignId('id_guru')->constrained('users')->onDelete('cascade');
            $table->integer('jp');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
