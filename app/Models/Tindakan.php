<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tindakan extends Model
{
    protected $table = 'tindakan';

    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'tarif',
        'keterangan',
    ];
}
