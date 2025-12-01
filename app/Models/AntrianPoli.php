<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AntrianPoli extends Model
{
    protected $table = 'antrian_poli';

    use HasFactory, Notifiable;

    protected $fillable = [
        'kunjungan_id',
        'status',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id', 'id');
    }

    public function pemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class);
    }

}
