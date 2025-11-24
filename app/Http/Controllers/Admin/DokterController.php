<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterDokter;
use App\Http\Requests\Admin\Update\UpdateMasterDokter;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Dokter';
        $dokter = Dokter::with( ['user', 'poli'])->orderByDesc('id')->get();

        return view('admin.master.dokter.index',compact('title','dokter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Dokter';
        $poli = Poli::all();

        return view('admin.master.dokter.form',compact('title', 'poli'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterDokter $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use ($request) {

                $user = User::create([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => 'dokter',
                    'password' => Hash::make($request->username),
                ]);

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $filename = 'dokter/profile_' . $user->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs( 'profiles', $filename, 'public');
                }
                $data = $request->validated();
                $data = [
                    'user_id' => $user->id,
                    'poli_id' => $request->poli_id,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $fotoPath,
                    'spesialisasi' => $request->spesialisasi,
                    'status' => $request->status,
                ];

                Dokter::create($data);
            });

            return redirect()->route('admin.master-dokter.index')->with([
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
        $dokter = Dokter::with('user', 'poli')->findOrFail($id);

        // Hitung umur
        $tgl_lahir = Carbon::parse($dokter->tgl_lahir);
        $umur = $tgl_lahir->age;

        // Format tanggal lahir & updated_at agar lebih ramah tampil
        $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
        $updated_at_formatted = Carbon::parse($dokter->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

        // Kirim data JSON lengkap
        return response()->json([
            'id' => $dokter->id,
            'user' => $dokter->user,
            'poli' => $dokter->poli,
            'jenis_kelamin' => $dokter->jenis_kelamin,
            'tempat_lahir' => $dokter->tempat_lahir,
            'tgl_lahir' => $tgl_lahir_formatted,
            'umur' => $umur,
            'email' => $dokter->user->email,
            'no_telp' => $dokter->no_telp,
            'alamat' => $dokter->alamat,
            'no_str' => $dokter->no_str,
            'no_sip' => $dokter->no_sip,
            'status' => $dokter->status,
            'spesialisasi' => $dokter->spesialisasi,
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
        $title = 'Perbarui Dokter';
        $poli = Poli::all();
        $dokter = Dokter::findOrFail($id);

        return view('admin.master.dokter.form',compact('title','dokter','poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterDokter $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use($request, $id) {

                $dokter = Dokter::findOrFail($id);
                $user = $dokter->user;
                $data = $request->validated();

                if ($request->hasFile('foto')) {
                    if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                        Storage::disk('public')->delete($dokter->foto);
                    }

                    $filename = 'dokter/profile_' . $dokter->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs('profiles', $filename, 'public');
                    $dokter->foto = $fotoPath;
                }

                $data = [
                    'poli_id' => $request->poli_id,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $dokter->foto,
                    'spesialisasi' => $request->spesialisasi,
                    'status' => $request->status,
                ];

                $dokter->update($data);

                $userData =[
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'email' => $request->email,
                ];

                if ($request->filled('new_password')) {
                    $userData['password'] = Hash::make($request->new_password);
                }

                $user->update($userData);
            });

            return redirect()->route('admin.master-dokter.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Memperbarui Dokter', [
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
            $dokter = Dokter::findOrFail($id);
            $dokter->delete();

            return redirect()->route('admin.master-dokter.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menghapus Dokter', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: '
            ]);
        }
    }
}
