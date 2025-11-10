<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Perawat extends Model
{
    protected $table = 'perawat';

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'poli_id',
        'no_str',
        'no_sip',
        'no_nira',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'status',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}
