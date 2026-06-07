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
        Schema::create('vocabulary_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->unique();
            $table->timestamps();
        });

        // Seed with existing levels
        $levels = DB::table('vocabularies')->select('level')->distinct()->pluck('level');
        foreach ($levels as $level) {
            DB::table('vocabulary_levels')->insert([
                'level' => $level,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary_levels');
    }
};
