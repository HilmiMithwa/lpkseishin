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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id('id_meeting');
            $table->foreignId('id_mapel')->constrained('mapel', 'id_mapel')->onDelete('cascade');
            $table->string('judul');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('meet_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['scheduled', 'ongoing', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
