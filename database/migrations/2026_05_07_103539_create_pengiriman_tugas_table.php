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
        Schema::create('pengiriman_tugas', function (Blueprint $table) {
            $table->id('id_pengiriman_tugas');
            $table->text('text_content')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamp('submitted_at');
            $table->enum('status', ['dikirim', 'dinilai', 'terlambat']);
            $table->decimal('nilai', 5,2)->nullable();
            $table->foreignId('id_tugas')->constrained('tugas','id_tugas')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_tugas');
    }
};
