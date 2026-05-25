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
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id('id_pendaftar');
            $table->string('nama_lengkap');
            $table->integer('no_whatsapp');
            $table->enum('jenis_kelamin', ['pria', 'wanita']);
            $table->string('alamat_lengkap');
            $table->string('no_ktp')->unique();
            $table->string('tempat_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};
