<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'id_user',
        'id_product',
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
        return $this->belongsTo(User::class, 'id_user');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_product');
    }


}
