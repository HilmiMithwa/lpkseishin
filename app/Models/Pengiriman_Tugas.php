<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman_Tugas extends Model
{
    protected $table = 'pengiriman_tugas';
    protected $primaryKey = 'id_pengiriman_tugas';

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    protected $fillable = [
        'text_content',
        'file_path',
        'submitted_at',
        'status',
        'nilai',
        'id_tugas',
        'id_user'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
}
