<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = 'vocabularies';
    protected $primaryKey = 'id_vocabulary';
 
    protected $fillable = [
        'kanji', 'furigana', 'romaji', 'meaning_en', 'meaning_id', 'level', 'definition_id', 'contextual_usage',
    ];
 
    protected $casts = [
        'level' => 'integer',
    ];
 
    /**
     * Progress semua user untuk vocabulary ini.
     */
    public function progresses()
    {
        return $this->hasMany(VocabProgress::class, 'id_vocabulary', 'id_vocabulary');
    }
 
    /**
     * Progress untuk user tertentu.
     */
    public function progressForUser(int $userId)
    {
        return $this->progresses()->where('id_user', $userId)->first();
    }
}
