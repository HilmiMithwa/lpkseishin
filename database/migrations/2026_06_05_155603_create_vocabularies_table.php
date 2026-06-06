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
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id("id_vocabulary");
            $table->string('kanji');
            $table->string('meaning_en');
            $table->string('meaning_id');
            $table->string('furigana');
            $table->string('romaji');
            $table->unsignedTinyInteger('level');
            $table->string('definition_id');
            $table->string('contextual_usage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
