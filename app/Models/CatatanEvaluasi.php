<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanEvaluasi extends Model
{
    protected $table = 'catatan_evaluasi';
    protected $primaryKey = 'id_catatan_evaluasi';

    protected $fillable = [
        'id_user',
        'id_mapel',
        'nama_evaluasi',
        'tipe_ujian',
        'skor',
        'skor_pg',
        'skor_essay',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}
