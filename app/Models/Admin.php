<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    protected $table = 'admin';

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'is_super_admin',
        'foto',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // protected static function booted()
    // {
    //     static::deleting(function ($admin) {
    //         // Hapus foto jika ada
    //         if ($admin->foto && Storage::disk('public')->exists($admin->foto)) {
    //             Storage::disk('public')->delete($admin->foto);
    //         }

    //         // Jika kamu mau sekalian hapus user terkait:
    //         if ($admin->user) {
    //             $admin->user->delete();
    //         }
    //     });
    // }
}
