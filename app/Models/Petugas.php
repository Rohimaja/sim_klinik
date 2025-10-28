<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Petugas extends Model
{
    protected $table = 'petugas';

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'email',
        'no_telp',
        'alamat',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
