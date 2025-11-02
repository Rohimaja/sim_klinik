<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Termwind\Components\Dd;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        try {
            $user = User::where('username', $request->username)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal. Password salah atau akun tidak ditemukan.',
                ], 401);
            } else if ($user->email_verified_at == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun anda belum aktif. Silahkan aktivasi terlebih dahulu pada menu registrasi.',
                ], 403);
            }

            $token = $user->createToken('mobile-token');
            $accessToken = $token->accessToken;

            $accessToken->expires_at = now()->addMinutes(15);
            $accessToken->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil terverifikasi',
                'token' => $token->plainTextToken,
                'expired_at' => $token->accessToken->expires_at,
                'token_type' => 'Bearer',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
