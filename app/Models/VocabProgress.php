<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocabProgress extends Model
{
    protected $table = 'vocab_progress';
    protected $primaryKey = 'id';
 
    protected $fillable = [
        'id_user',
        'vocabulary_id',
        'is_memorized',
        'is_favorite',
    ];

    protected $casts = [
        'is_memorized' => 'boolean',
        'is_favorite'  => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
