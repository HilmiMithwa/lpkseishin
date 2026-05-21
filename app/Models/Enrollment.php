<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollment';
    protected $primaryKey = 'id_enrollment';

    protected $fillable = [
        'id_user',
        'order_id',
        'transaction_id',
        'gross_amount',
        'snap_token',
        'jenis_program',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_daftar'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


}
