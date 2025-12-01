<?php

use App\Http\Controllers\Petugas\KunjunganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return view('auth/login');
});

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role;

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

// Route::prefix('admin/masterData')->group(function () {
//     Route::get('/dokter', fn() => view('admin.masterData.dokter.view_dokter'))->name('dokter.index');
//     Route::get('/dokter/form', fn() => view('admin.masterData.dokter.form_dokter'))->name('dokter.form');
//     Route::get('/dokter/edit', fn() => view('admin.masterData.dokter.edit_dokter'))->name('dokter.edit');

//     Route::get('/perawat', fn() => view('admin.masterData.perawat.view_perawat'))->name('perawat.index');
//     Route::get('/perawat/form', fn() => view('admin.masterData.perawat.form_perawat'))->name('perawat.form');
//     Route::get('/perawat/edit', fn() => view('admin.masterData.perawat.edit_perawat'))->name('perawat.edit');

//     Route::get('/petugas', fn() => view('admin.masterData.petugas.view_petugas'))->name('petugas.index');
//     Route::get('/petugas/form', fn() => view('admin.masterData.petugas.form_petugas'))->name('petugas.form');
//     Route::get('/petugas/edit', fn() => view('admin.masterData.petugas.edit_petugas'))->name('petugas.edit');

//     Route::get('/pasien', fn() => view('admin.masterData.pasien.view_pasien'))->name('pasien.index');
//     Route::get('/pasien/form', fn() => view('admin.masterData.pasien.form_pasien'))->name('pasien.form');
//     Route::get('/pasien/edit', fn() => view('admin.masterData.pasien.edit_pasien'))->name('pasien.edit');

//     Route::get('/poli', fn() => view('admin.masterData.poli.view_poli'))->name('poli.index');
//     Route::get('/poli/form', fn() => view('admin.masterData.poli.form_poli'))->name('poli.form');
//     Route::get('/poli/edit', fn() => view('admin.masterData.poli.edit_poli'))->name('poli.edit');

//     Route::get('/obat', fn() => view('admin.masterData.obat.view_obat'))->name('obat.index');
//     Route::get('/obat/form', fn() => view('admin.masterData.obat.form_obat'))->name('obat.form');
//     Route::get('/obat/edit', fn() => view('admin.masterData.obat.edit_obat'))->name('obat.edit');

//     Route::get('/tindakan', fn() => view('admin.masterData.tindakan.view_tindakan'))->name('tindakan.index');
//     Route::get('/tindakan/form', fn() => view('admin.masterData.tindakan.form_tindakan'))->name('tindakan.form');
//     Route::get('/tindakan/edit', fn() => view('admin.masterData.tindakan.edit_tindakan'))->name('tindakan.edit');

//     Route::get('/jadwal', fn() => view('admin.masterData.jadwal.view_jadwal'))->name('jadwal.index');
//     Route::get('/jadwal/form', fn() => view('admin.masterData.jadwal.form_jadwal'))->name('jadwal.form');
//     Route::get('/jadwal/edit', fn() => view('admin.masterData.jadwal.edit_jadwal'))->name('jadwal.edit');
// });

// LAPORAN
Route::prefix('admin/laporan')->group(function () {
    Route::get('/kunjungan', fn() => view('admin.laporan.kunjungan'))->name('laporan.kunjungan');
    Route::get('/pendapatan', fn() => view('admin.laporan.pendapatan'))->name('laporan.pendapatan');
    Route::get('/stokobat', fn() => view('admin.laporan.stokobat'))->name('laporan.stokobat');
});

    Route::get('/rfid/kunjungan',[KunjunganController::class,'prosesKunjungan']);




Route::middleware('auth')->group(function () {

    Route::get('/pengaturan', [PengaturanController::class, 'profile'])
        ->name('pengaturan.profile');

    Route::get('/pengaturan/password', [PengaturanController::class, 'password'])
        ->name('pengaturan.password');

    Route::get('/pengaturan/tampilan', [PengaturanController::class, 'tampilan'])
        ->name('pengaturan.tampilan');

});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/dokter.php';
require __DIR__.'/pasien.php';
require __DIR__.'/perawat.php';
require __DIR__.'/petugas.php';
require __DIR__.'/superadmin.php';


// $user = App\Models\Admin::where('email', 'admin@example.com')->first();
