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
        Schema::create('enrollment_list', function (Blueprint $table) {
            $table->id('id_enrollment_access');
            $table->timestamps();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_mapel')->nullable()->constrained('mapel', 'id_mapel')->onDelete('cascade');
            $table->foreignId('id_modul')->nullable()->constrained('modul', 'id_modul')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_list');
    }
};
