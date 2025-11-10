<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pasien extends Model
{
    protected $table = 'pasien';

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'no_rm',
        'no_bpjs',
        'jenis_pasien',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'foto',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
