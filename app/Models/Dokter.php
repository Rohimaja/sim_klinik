<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Dokter extends Model
{
    protected $table = 'dokter';

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'nama',
        'poli_id',
        'no_str',
        'no_sip',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'email',
        'no_telp',
        'alamat',
        'spesialisasi',
        'status',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}
