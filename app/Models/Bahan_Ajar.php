<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan_Ajar extends Model
{
    protected $table = 'bahan_ajar';
    protected $primaryKey = 'id_bahan_ajar';

    protected $fillable = [
        'nama_bahan_ajar',
        'type',
        'is_complete',
        'video_title',
        'video_url',
        'video_duration',
        'focus_skill',
        'key_points',
        'objective',
        'sensei_note',
        'bahan_ajar_description',
        'nama_dokumen_ajar',
        'path_file_dokumen_ajar',
        'ukuran_file_dokumen_ajar',
        'unggah_file_dokumen_ajar'
    ];


    public function modul() {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}
