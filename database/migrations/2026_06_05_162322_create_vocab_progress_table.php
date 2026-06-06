<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Determine if the migration should be run within a transaction.
     *
     * @var bool
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<< HEAD:database/migrations/2026_05_18_082236_create_vocab_progress_table.php
        if (!Schema::hasTable('vocab_progress')) {
            Schema::create('vocab_progress', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
                $table->string('vocabulary_id');
                $table->boolean('is_memorized')->default(false);
                $table->timestamps();
                $table->unique(['id_user', 'vocabulary_id']);
            });
        }
=======
        Schema::create('vocab_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_vocabulary')->constrained('vocabularies', 'id_vocabulary')->onDelete('cascade');
            $table->boolean('is_memorized')->default(false);
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
            $table->unique(['id_user', 'id_vocabulary']);
        });
>>>>>>> a26d60bfda34928d435637d7483508501238343f:database/migrations/2026_06_05_162322_create_vocab_progress_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocab_progress');
    }
};
