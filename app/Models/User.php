<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * @property int $role_id
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel enrollment
     */
    public function enrollment()
    {
        // User memiliki satu pendaftaran (One-to-One)
        return $this->hasOne(Enrollment::class, 'id_user', 'id');
    }

    //biar user punya data masing-masing
    public function mapels() 
    {
        return $this->belongsToMany(Mapel::class, 'enrollment_list', 'id_user', 'id_mapel' )->withTimestamps();
    }

    public function moduls()
    {
        return $this->belongsToMany(Modul::class, 'enrollment_list', 'id_user', 'id_modul')->withTimestamps();
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_guru', 'id_user')->withTimeStamps();
    }

}
