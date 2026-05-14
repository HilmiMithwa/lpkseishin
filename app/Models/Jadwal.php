<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'judul_pertemuan',
        'start_time',
        'end_time',
        'lokasi_pertemuan',
        'id_guru'
    ];

    public function guru() {
        return $this->belongsTo(User::class, 'id_guru','id_user');
    }
   
}
