<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiQuestionImage extends Model
{
    protected $table = 'evaluasi_question_images';
    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'id_soal',
        'image_path'
    ];

    public function question() {
        return $this->belongsTo(EvaluasiQuestion::class, 'id_soal', 'id_soal');
    }}
