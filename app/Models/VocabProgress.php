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
    ];

    protected $casts = [
        'is_memorized' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
