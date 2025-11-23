<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class ChangePassword extends Controller
{
    function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8'
        ]);

        $email = $request->email;
        $password = $request->password;
        $hashedPassword = Hash::make($password);

        try {
            $pasien = User::where('email', $email)->first();

            if (!$pasien) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pasien tidak terdaftar dalam database'
                ]);
            }
            $pasien->update(['password' => $hashedPassword]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui password: ' . $e->getMessage()
            ]);
        }


    }

    function checkPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $email = $request->email;
        $password = $request->password;

        try {
            $pasien = User::where('email', $email)->first();

            if (!$pasien) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pasien tidak terdaftar dalam database'
                ]);
            }

            if (!Hash::check($password, $pasien->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password tidak sesuai.',
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Password sudah sesuai'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengecek password: ' . $e->getMessage()
            ]);
        }
    }
}
