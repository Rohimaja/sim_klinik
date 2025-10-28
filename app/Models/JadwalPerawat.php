<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JadwalPerawat extends Model
{
    protected $table = 'jadwal_perawat';
    use HasFactory, Notifiable;

    protected $fillable = [
        'perawat_id',
        'hari',
        'jam_mulai',
        'jam_akhir'
    ];
        public function perawat()
    {
        return $this->belongsTo(Perawat::class, 'perawat_id', 'id');
    }
}
