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
        Schema::create('catatan_mingguan', function (Blueprint $table) {
            $table->id('id_catatan_mingguan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_mapel');
            $table->integer('minggu_ke');
            $table->integer('score_word')->default(0);
            $table->integer('score_kotoba')->default(0);
            $table->integer('score_bunpou')->default(0);
            $table->integer('score_kanji')->default(0);
            $table->integer('score_choukai')->default(0);
            $table->integer('score_kaiwa')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_mingguan');
    }
};
