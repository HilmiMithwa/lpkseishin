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
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id('id_enrollment');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');

            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->integer('gross_amount');
            
            $table->string('snap_token')->nullable();
            $table->string('jenis_program');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran');
            $table->date('tanggal_daftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
