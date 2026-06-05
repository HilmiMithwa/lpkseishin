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
            $table->id();
            $table->string('kanji');
            $table->string('furigana');
            $table->string('romaji');
            $table->string('meaning_en');
            $table->string('meaning_id');
            $table->text('definition');
            $table->text('usage_jp');
            $table->text('usage_en');
            $table->unsignedTinyInteger('level');
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
