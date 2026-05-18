<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment_List extends Model
{
    protected $table = 'enrollment_list';
    protected $primaryKey = 'id_enrollment_list';

    protected $fillable = [
        'jenis_program',
        'id_user'
    ];

        
}
