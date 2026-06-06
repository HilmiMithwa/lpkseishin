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
        Schema::create('vocab_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_vocabulary')->constrained('vocabularies', 'id_vocabulary')->onDelete('cascade');
            $table->boolean('is_memorized')->default(false);
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
            $table->unique(['id_user', 'id_vocabulary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocab_progress');
    }
};
