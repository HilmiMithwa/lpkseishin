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
        Schema::table('vocab_progress', function (Blueprint $table){
            $table->dropUnique(['id_user', 'vocabulary_id']);
 
            $table->unsignedBigInteger('vocabulary_id')->change();
 
            $table->foreign('vocabulary_id')
                  ->references('id')
                  ->on('vocabularies')
                  ->onDelete('cascade');
 
            $table->unique(['id_user', 'vocabulary_id']);
 
            $table->boolean('is_favorite')->default(false)->after('is_memorized');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vocab_progress', function (Blueprint $table) {
            $table->dropUnique(['id_user', 'vocabulary_id']);
            $table->dropForeign(['vocabulary_id']);
            $table->dropColumn('is_favorite');
            $table->string('vocabulary_id')->change();
            $table->unique(['id_user', 'vocabulary_id']);
        });
    }
};
