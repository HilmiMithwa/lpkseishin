<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';
    protected $primaryKey = 'id_program';

    protected $fillable = [
        'nama',
        'deskripsi',
        'theme_color',
        'is_active',
    ];

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_program', 'id_program');
    }

    public function getActiveBatchesCountAttribute()
    {
        // Batch status varies, assuming active are those not marked 'selesai' or 'batal'
        // Let's just check if status is 'pendaftaran' or 'berjalan' or 'aktif'
        return $this->batches()
            ->whereIn('status', ['pendaftaran', 'berjalan', 'aktif', 'Active'])
            ->count();
    }

    public function getTotalStudentsAttribute()
    {
        return $this->batches()->withCount('students')->get()->sum('students_count');
    }
}
