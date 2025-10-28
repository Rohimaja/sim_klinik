<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';

    use HasFactory, Notifiable;

    protected $fillable = [
        'dokter_id',
        'poli_id',
        'hari',
        'jam_mulai',
        'jam_akhir',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}
