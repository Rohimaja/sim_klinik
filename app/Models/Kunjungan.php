<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    use HasFactory, Notifiable;

    protected $fillable = [
        'pasien_id',
        'poli_id',
        'dokter_id',
        'no_antrian',
        'tgl_kunjungan',
        'jam_awal',
        'jam_akhir',
        'keluhan_awal',
        'status',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }

        public function skrining()
    {
        return $this->hasOne(Skrining::class);
    }

}
