<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterPasien;
use App\Http\Requests\Admin\Update\UpdateMasterPasien;
use App\Models\Pasien;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Pasien';
        $pasien = Pasien::all();

        return view('admin.master.pasien.index',compact('title','pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pasien';

        return view('admin.master.pasien.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterPasien $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
            'no_bpjs' => trim($request->no_bpjs),
        ]);

        try {

            DB::transaction(function () use ($request) {

                $no_rm = $this->generateNoRm();

                $user = User::create([
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => 'pasien',
                    'password' => Hash::make($request->username),
                ]);

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $filename = 'pasien/profile_' . $user->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs( 'profiles', $filename, 'public');
                }

                $data = $request->validated();

                $data = [
                    'user_id' => $user->id,
                    'nama' => $request->nama,
                    'no_rm' => $no_rm,
                    'jenis_pasien' => $request->jenis_pasien,
                    'no_bpjs' => $request->no_bpjs,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $fotoPath,
                    'status' => $request->status,
                ];

                Pasien::create($data);
            });

            return redirect()->route('admin.master-pasien.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Dokter', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan data: '
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pasien = Pasien::with('user')->findOrFail($id);

            // Hitung umur
            $tgl_lahir = Carbon::parse($pasien->tgl_lahir);
            $umur = $tgl_lahir->age;

            // Format tanggal lahir & updated_at agar lebih ramah tampil
            $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
            $updated_at_formatted = Carbon::parse($pasien->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

            // Kirim data JSON lengkap
            return response()->json([
                'id' => $pasien->id,
                'user' => $pasien->user,
                'poli' => $pasien->poli,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'tempat_lahir' => $pasien->tempat_lahir,
                'tgl_lahir' => $tgl_lahir_formatted,
                'umur' => $umur,
                'email' => $pasien->user->email,
                'no_telp' => $pasien->no_telp,
                'alamat' => $pasien->alamat,
                'no_bpjs' => $pasien->no_bpjs,
                'jenis_pasien' => $pasien->jenis_pasien,
                'updated_at' => $updated_at_formatted,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Pasien';
        $pasien = Pasien::findOrFail($id);

        return view('admin.master.pasien.form',compact('title','pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPasien $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
            'no_bpjs' => trim($request->no_bpjs),
        ]);

        try {

            DB::transaction(function () use($request, $id) {

                $pasien = Pasien::findOrFail($id);
                $user = $pasien->user;
                $data = $request->validated();

                if ($request->hasFile('foto')) {
                    if ($pasien->foto && Storage::disk('public')->exists($pasien->foto)) {
                        Storage::disk('public')->delete($pasien->foto);
                    }

                    $filename = 'pasien/profile_' . $pasien->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs('profiles', $filename, 'public');
                    $pasien->foto = $fotoPath;
                }

                $data = [
                    'nama' => $request->nama,
                    'jenis_pasien' => $request->jenis_pasien,
                    'no_bpjs' => $request->no_bpjs,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $pasien->foto,
                    'status' => $request->status,
                ];

                $pasien->update($data);

                $userData =[
                    'username' => $request->username,
                    'email' => $request->email,
                ];

                if ($request->filled('new_password')) {
                    $userData['password'] = Hash::make($request->new_password);
                }

                $user->update($userData);
            });

            return redirect()->route('admin.master-pasien.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Memperbarui Pasien', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: '
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            $pasien->delete();

            return redirect()->route('admin.master-pasien.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menghapus Pasien', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: '
            ]);
        }
    }

    private function generateNoRm()
    {
        // Ambil nomor RM terakhir
        $last = Pasien::orderBy('no_rm', 'desc')->first();

        if ($last) {
            // Ambil 8 digit terakhir dan ubah ke integer
            $lastNumber = (int) $last->no_rm;

            // Tambah 1, lalu padding jadi 8 digit
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data sama sekali
            $newNumber = '0001';
        }

        return $newNumber;
    }

}
