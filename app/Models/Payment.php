<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'id_user',
        'id_batch',
        'amount',
        'payment_method',
        'payment_date',
        'payment_for',
        'description',
        'proof_path',
        'status',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch', 'id_batch');
    }
}
