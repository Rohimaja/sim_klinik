<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpToken;
use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class RegisterController extends Controller
{
    public function registerAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50',
            'email' => 'required|email',
            'no_telp' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $email = $request->email;
        $noTelp = $request->no_telp;
        $password = $request->password;
        $role = "pasien";

        // DB::beginTransaction();

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
                $this->sendOTP($email);
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
                'name' => $username,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role
            ]);

            // DB::commit();

            $this->sendOTP($email);

            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendOTP(String $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan',
            ], 404);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun sudah tervalidasi, silahkan login',
            ], 400);
        }

        $OTP = rand(1000, 9999);
        $hashedOTP = Hash::make($OTP);
        $expiredAt = Carbon::now()->addMinutes(15);

        OtpToken::updateOrCreate(
            ['email' => $email],
            ['token' => $hashedOTP, 'expired_at' => $expiredAt]
        );

        try {
            Mail::send([], [], function ($message) use ($email, $OTP, $user) {
                $message->to($email)
                    ->subject('Verifikasi Akun')
                    ->html('
                    Halo <b>' . $user->name . ',</b><br>
                    Berikut kode OTP kamu, masukkan kode ini untuk melanjutkan validasi akun kamu.<br><br>
                    Kode OTP Anda adalah: <b>' . $OTP . '</b><br>
                    Kode ini akan kedaluwarsa dalam 15 menit.<br>
                    Demi keamanan, jangan beritahu kode tersebut kepada siapapun dan segera ganti password kamu dengan ketat.
                ');
                $message->from('medigo@gmail.com', 'MediGo');
            });

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim OTP: ' . $e->getMessage()
            ], 500);
        }

    }
}
