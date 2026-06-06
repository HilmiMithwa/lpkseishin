<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';
    protected $primaryKey = 'id_batch';

    protected $fillable = [
        'nama',
        'nama_program',
        'level_target',
        'deskripsi',
        'waktu_mulai',
        'waktu_berakhir',
        'durasi',
        'jadwal',
        'status',
        'quota',
    ];

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'id_batch', 'id_batch');
    }

    public function getNamaBatchAttribute()
    {
        return $this->nama;
    }
}