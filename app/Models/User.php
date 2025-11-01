<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
    ];

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



    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    public function perawat()
    {
        return $this->hasOne(Perawat::class);
    }

    public function pasien()
    {
        return $this->hasOne(Pasien::class);
    }


    public function getDisplayNameAttribute()
    {
        switch ($this->role) {
            case 'admin':
                return $this->admin?->nama ?? 'Admin';
            case 'dokter':
                return $this->dokter?->nama ?? 'Dokter';
            case 'perawat':
                return $this->perawat?->nama ?? 'Perawat';
            case 'petugas':
                return $this->petugas?->nama ?? 'Petugas';
            case 'pasien':
                return $this->pasien?->nama ?? 'Pasien';
            default:
                return $this->nama ?? 'User';
        }
    }



}
