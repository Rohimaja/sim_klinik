<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Poli extends Model
{
    protected $table = 'poli';

    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'keterangan',
        'status',
    ];
}
