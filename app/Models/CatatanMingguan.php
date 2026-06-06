<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanMingguan extends Model
{
    protected $table = 'catatan_mingguan';
    protected $primaryKey = 'id_catatan_mingguan';

    protected $fillable = [
        'id_user',
        'id_mapel',
        'minggu_ke',
        'score_word',
        'score_kotoba',
        'score_bunpou',
        'score_kanji',
        'score_choukai',
        'score_kaiwa',
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
