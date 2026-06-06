<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiQuestion extends Model
{
    protected $table = 'evaluasi_questions';
    protected $primaryKey = 'id_soal';

    protected $fillable = [
        'id_evaluasi',
        'tipe_soal',
        'pertanyaan',
        'pilihan',
        'kunci_jawaban'
    ];

    protected $casts = [
        'pilihan' => 'array'
    ];

    public function evaluasi() {
        return $this->belongsTo(Evaluasi::class, 'id_evaluasi', 'id_evaluasi');
    }

    public function images() {
        return $this->hasMany(EvaluasiQuestionImage::class, 'id_soal', 'id_soal');
    }}
