<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectDiscussion extends Model
{
    protected $table = 'subject_discussions';

    protected $fillable = [
        'id_mapel',
        'user_id',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}
