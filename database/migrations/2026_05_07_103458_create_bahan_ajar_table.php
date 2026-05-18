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
            $table->string('nama_bahan_ajar'); 
            $table->enum('type', ['practice', 'theory'])->default('theory');
            $table->boolean('is_complete')->default(false);

            $table->string('video_title')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_duration')->nullable();
            $table->string('focus_skill')->nullable();
            $table->string('key_points')->nullable();
            $table->string('objective')->nullable();
            $table->string('sensei_note')->nullable();

            $table->string('bahan_ajar_description')->nullable();

            
            $table->string('nama_dokumen_ajar')->nullable();
            $table->string('path_file_dokumen_ajar')->nullable();
            $table->integer('ukuran_file_dokumen_ajar')->nullable();
            $table->timestamp('unggah_file_dokumen_ajar')->nullable();

            $table->foreignId('id_modul')->constrained('modul', 'id_modul')->onDelete('cascade');
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
