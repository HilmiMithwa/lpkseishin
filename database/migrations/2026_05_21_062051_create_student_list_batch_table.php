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
        if (!Schema::hasTable('student_list_batch')) {
            Schema::create('student_list_batch', function (Blueprint $table) {
                $table->id('id_studentbatch');
                $table->foreignId('id_batch')->constrained('batch', 'id_batch')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
                $table->date('register_date');
                $table->integer('average_score')->nullable();
                $table->enum('status', ['Active', 'Inactive', 'Completed'])->default('Active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_list_batch');
    }
};
