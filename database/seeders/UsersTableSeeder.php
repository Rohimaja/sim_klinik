<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // ===============================
        // 1️⃣ Masukkan data ke tabel users
        // ===============================
        $users = [
            [
                'name' => 'Admin Utama',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Klinik',
                'username' => 'petugas',
                'email' => 'petugas@example.com',
                'role' => 'petugas',
            ],
            [
                'name' => 'Perawat Klinik',
                'username' => 'perawat',
                'email' => 'perawat@example.com',
                'role' => 'perawat',
            ],
            [
                'name' => 'Pasien Contoh',
                'username' => 'pasien',
                'email' => 'pasien@example.com',
                'role' => 'pasien',
            ],
            [
                'name' => 'Dokter Klinik',
                'username' => 'dokter',
                'email' => 'dokter@example.com',
                'role' => 'dokter',
            ],
        ];

        foreach ($users as $user) {
            $userId = DB::table('users')->insertGetId([
                'username' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // =================================
            // 2️⃣ Buat data relasi sesuai rolenya
            // =================================
            match ($user['role']) {

                'admin' => DB::table('admin')->insert([
                    'user_id' => $userId,
                    'nama' => $user['name'],
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Jember',
                    'tgl_lahir' => '2005-01-28',
                    'email' => 'admin@example.com',
                    'no_telp' => '087997765362',
                    'alamat' => 'Jember',
                    'is_super_admin' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]),

                default => null,
            };
        }
    }
}
