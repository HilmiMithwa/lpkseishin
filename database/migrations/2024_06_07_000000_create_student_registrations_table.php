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
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            
            // Personal Data
            $table->string('full_name');
            $table->string('whatsapp_number');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('ktp_number')->unique();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->longText('full_address');
            
            // Emergency Contact
            $table->string('contact_name');
            $table->string('contact_relationship');
            $table->string('contact_whatsapp');
            
            // Requirements
            $table->boolean('requirement_one')->default(false);
            $table->boolean('requirement_two')->default(false);
            
            // Education
            $table->enum('education_level', ['SMP', 'SMA', 'SMK', 'Kuliah'])->nullable();
            $table->string('school_name')->nullable();
            $table->string('major')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->longText('organization_experience')->nullable();
            
            // Japanese Language
            $table->enum('japanese_ability', ['yes', 'no'])->nullable();
            $table->enum('japanese_level', ['N1', 'N2', 'N3', 'N4', 'N5'])->nullable();
            
            // Documents
            $table->string('ktp_photo')->nullable();
            $table->string('family_card_photo')->nullable();
            $table->string('birth_certificate_photo')->nullable();
            $table->string('passport_photo')->nullable();
            
            // Payment
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
            $table->integer('current_step')->default(1);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
