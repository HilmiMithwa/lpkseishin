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
        Schema::rename('enrollment_list', 'enrollment_access');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('enrollment_access', 'enrollment_list');
    }
};
