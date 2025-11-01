<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Cek apakah user valid dan role-nya admin
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Anda bukan admin.');
        }

        // Cek apakah admin ini superadmin
        if (optional($user->admin)->is_super_admin != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman super admin.');
        }

        return $next($request);
    }
}
