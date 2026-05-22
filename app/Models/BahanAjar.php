<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanAjar extends Model 
{

    protected $table = 'bahan_ajar';


    protected $primaryKey = 'id_bahan_ajar';

    protected $fillable = [
        'nama_file',
        'path_file',
        'ukuran_file',
        'unggah_file',
        'id_rps'
    ];

}