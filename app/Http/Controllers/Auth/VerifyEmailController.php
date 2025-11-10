<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */

    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! URL::hasValidSignature($request)) {
            abort(403, 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Hash email tidak cocok.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('status', 'Email sudah diverifikasi.');
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login')->with('status', 'Email berhasil diverifikasi');
    }
}
