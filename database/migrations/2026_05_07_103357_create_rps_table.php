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
        Schema::create('rps', function (Blueprint $table) {
            $table->id('id_rps');
            $table->integer('pertemuan');
            $table->text('deskripsi_rps');
            $table->text('certification_target');
            $table->text('schedule');
            $table->integer('total_duration');
            $table->foreignId('id_mapel')->constrained('mapel','id_mapel')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps');
    }
};
