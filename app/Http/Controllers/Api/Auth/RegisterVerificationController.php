<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpToken;
use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Mail;

class RegisterVerificationController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

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

            return response()->json([
                'status' => 'success',
                'message' => 'kode OTP berhasil dikirim'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim OTP: ' . $e->getMessage()
            ], 500);
        }

    }

    public function checkOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required'
        ]);

        $otpRecord = OtpToken::where('email', $request->email)
            ->where('expired_at', '>=', Carbon::now())
            ->first();

        $pasien = User::where('email', $request->email)->first();

        if (!$otpRecord || !$pasien) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->token, $otpRecord->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP tidak valid atau telah kedaluwarsa'
            ]);
        }

        $emailVerifiedAt = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $updated = User::where('email', $request->email)
            ->update([
                'email_verified_at' => $emailVerifiedAt,
            ]);

        if ($updated > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'Validation Success',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP is valid'
        ]);
    }
}
