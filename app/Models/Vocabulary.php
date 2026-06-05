<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = 'vocabularies';
 
    protected $fillable = [
        'kanji',
        'furigana',
        'romaji',
        'meaning_en',
        'meaning_id',
        'definition',
        'usage_jp',
        'usage_en',
        'level',
    ];
 
    protected $casts = [
        'level' => 'integer',
    ];
 
    /**
     * Progress semua user untuk vocabulary ini.
     */
    public function progresses()
    {
        return $this->hasMany(VocabProgress::class, 'vocabulary_id');
    }
 
    /**
     * Progress untuk user tertentu.
     */
    public function progressForUser(int $userId)
    {
        return $this->progresses()->where('id_user', $userId)->first();
    }
}
