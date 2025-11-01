<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    $role = auth()->user()->role;

    // 🔹 Cek dulu super admin
    if ($role === 'admin' && $user->admin->is_super_admin == 1) {
        return redirect()->route('superadmin.dashboard');
    }

    // 🔹 Cek admin biasa
    if ($role === 'admin' && $user->admin->is_super_admin == 0) {
        return redirect()->route('admin.dashboard');
    }

    // 🔹 Cek role lain
    if (in_array($role, ['dokter','petugas','perawat','pasien'])) {
        return redirect()->route("$role.dashboard");
    }

    abort(403);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/dokter.php';
require __DIR__.'/pasien.php';
require __DIR__.'/perawat.php';
require __DIR__.'/petugas.php';
require __DIR__.'/superadmin.php';


$user = App\Models\Admin::where('email', 'admin@example.com')->first();
