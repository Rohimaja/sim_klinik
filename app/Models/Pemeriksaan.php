<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';

    use HasFactory, Notifiable;

    protected $fillable = [
        'antrian_poli_id',
        'dokter_id',
        'keluhan',
        'diagnosa',
        'tindakan',
        'catatan',
        'tensi',
        'suhu',
        'tgl_periksa',
    ];

    public function antrian()
    {
        return $this->belongsTo(AntrianPoli::class, 'antrian_poli_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }

}
