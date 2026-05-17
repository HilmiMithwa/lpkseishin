<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyWord extends Model
{
    protected $table = 'daily_words';

    protected $fillable = [
        'kanji',
        'romaji',
        'meaning_en',
        'meaning_id',
    ];
}
