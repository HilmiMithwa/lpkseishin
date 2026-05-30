<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'date_formatted',
        'id_mapel',
        'id_guru'
    ];

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function guru() {
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }
}
