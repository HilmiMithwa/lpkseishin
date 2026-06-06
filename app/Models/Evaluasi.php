<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $table = 'evaluasis';
    protected $primaryKey = 'id_evaluasi';

    protected $fillable = [
        'id_modul',
        'judul',
        'bahasa',
        'durasi_menit',
        'tipe',
        'panduan'
    ];

    protected $casts = [
        'panduan' => 'array'
    ];

    public function modul() {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    public function questions() {
        return $this->hasMany(EvaluasiQuestion::class, 'id_evaluasi', 'id_evaluasi');
    }}
