<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Obat extends Model
{
    protected $table = 'obat';

    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'jenis_obat',
        'stok',
        'harga',
        'keterangan',
    ];
}
