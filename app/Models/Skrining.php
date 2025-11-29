<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Skrining extends Model
{
    protected $table = 'skrining';

    use HasFactory, Notifiable;

    protected $fillable = [
        'kunjungan_id',
        'perawat_id',
        'berat_badan',
        'tinggi_badan',
        'denyut_nadi',
        'tensi',
        'suhu',
        'keluhan_utama',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id', 'id');
    }

    public function perawat()
    {
        return $this->belongsTo(Perawat::class, 'perawat_id', 'id');
    }

}
