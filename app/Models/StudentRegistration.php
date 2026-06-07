<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $table = 'student_registrations';
    
    protected $fillable = [
        // Personal Data
        'full_name',
        'whatsapp_number',
        'gender',
        'ktp_number',
        'birth_place',
        'birth_date',
        'full_address',
        
        // Emergency Contact
        'contact_name',
        'contact_relationship',
        'contact_whatsapp',
        
        // Requirements
        'requirement_one',
        'requirement_two',
        
        // Education
        'education_level',
        'school_name',
        'major',
        'graduation_year',
        'gpa',
        'organization_experience',
        
        // Japanese Language
        'japanese_ability',
        'japanese_level',
        
        // Documents
        'ktp_photo',
        'family_card_photo',
        'birth_certificate_photo',
        'passport_photo',
        
        // Payment
        'payment_proof',
        'status',
        'current_step'
    ];
    
    protected $casts = [
        'birth_date' => 'date',
        'requirement_one' => 'boolean',
        'requirement_two' => 'boolean',
        'japanese_ability' => 'boolean',
    ];
}
