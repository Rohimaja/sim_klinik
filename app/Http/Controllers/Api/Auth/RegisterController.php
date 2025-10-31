<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function registerAccount(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|max:50',
            'jenis_kelamin' => 'required|in:P,L',
            'email' => 'required|email',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'password' => 'required',
        ]);

        $nama = $request->nama;
        $username = $request->username;
        $jenisKelamin = $request->jenis_kelamin;
        $email = $request->email;
        $tempatLahir = $request->tempat_lahir;
        $tanggalLahir = $request->tanggal_lahir;
        $alamat = $request->alamat;
        $noTelp = $request->no_telp;
        $password = $request->password;
        $role = "pasien";

        DB::beginTransaction();

        try {

            $conflictEmail = User::where('email', $email)
                ->whereNull('email_verified_at')->first();             
            $conflictEmailVerif = User::where('email', $email)
                ->whereNotNull('email_verified_at')->first();
            $conflictUsername = User::where('username', $username)->first();

            if ($conflictEmailVerif) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email telah digunakan dan sudah verifikasi'
                ], 409);
            }

            if ($conflictEmail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email telah digunakan dan belum verifikasi'
                ], 409);
            }

            if ($conflictUsername) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username telah digunakan'
                ], 409);
            }

            $users = User::create([
                'name' => $nama,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role
            ]);

            $pasien = Pasien::create([
                'user_id' => $users->id,
                'nama' => $nama,
                'email' => $email,
                'jenis_kelamin' => $jenisKelamin,
                'tempat_lahir' => $tempatLahir,
                'tgl_lahir' => $tanggalLahir,
                'alamat' => $alamat,
                'no_telp' => $noTelp,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data pasien berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
