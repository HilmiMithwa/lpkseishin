<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';

    protected $fillable = [
        'id_batch',
        'nama_mapel',
        'deskripsi_mapel',
        'id_guru',  
        'jp',
        'status',
        'target',
        'jadwal',
        'min_score'
    ];

    public function guru() {
        return $this->belongsTo(User::class, 'id_guru');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch', 'id_batch');
    }
    
    public function rps() {
        return $this->hasMany(Rps::class, 'id_mapel', 'id_mapel');
    }

    public function modul() {
        return $this->hasMany(Modul::class, 'id_mapel', 'id_mapel');
    }

    public function announcements() {
        return $this->hasMany(Announcement::class, 'id_mapel', 'id_mapel');
    }

    public function enrollmentAccess()
    {
        return $this->hasMany(Enrollment_List::class, 'id_mapel', 'id_mapel');
    }

}
