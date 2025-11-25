<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterPetugas;
use App\Http\Requests\Admin\Update\UpdateMasterPetugas;
use App\Models\Petugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Petugas';
        $petugas = Petugas::with('user')->get();

        return view('admin.master.petugas.index',compact('title','petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Petugas';

        return view('admin.master.petugas.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterPetugas $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use ($request) {

                $user = User::create([
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => 'petugas',
                    'password' => Hash::make($request->username),
                ]);

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $filename = 'petugas/profile_' . $user->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs( 'profiles', $filename, 'public');
                }
                $data = $request->validated();
                $data = [
                    'user_id' => $user->id,
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'no_kta' => $request->no_kta,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $fotoPath,
                    'status' => $request->status,
                ];

                Petugas::create($data);
            });

            return redirect()->route('admin.master-petugas.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Petugas', [
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
            $petugas = Petugas::with('user')->findOrFail($id);

            // Hitung umur
            $tgl_lahir = Carbon::parse($petugas->tgl_lahir);
            $umur = $tgl_lahir->age;

            // Format tanggal lahir & updated_at agar lebih ramah tampil
            $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
            $updated_at_formatted = Carbon::parse($petugas->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

            // Kirim data JSON lengkap
            return response()->json([
                'id' => $petugas->id,
                'user' => $petugas->user,
                'jenis_kelamin' => $petugas->jenis_kelamin,
                'tempat_lahir' => $petugas->tempat_lahir,
                'tgl_lahir' => $tgl_lahir_formatted,
                'umur' => $umur,
                'email' => $petugas->user->email,
                'no_telp' => $petugas->no_telp,
                'alamat' => $petugas->alamat,
                'no_str' => $petugas->no_str,
                'no_sip' => $petugas->no_sip,
                'no_kta' => $petugas->no_nira,
                'jabatan' => $petugas->jabatan,
                'status' => $petugas->status,
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
        $title = 'Perbarui Petugas';
        $petugas = Petugas::findOrFail($id);

        return view('admin.master.petugas.form',compact('title','petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPetugas $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use($request, $id) {

                $petugas = Petugas::findOrFail($id);
                $user = $petugas->user;
                $data = $request->validated();

                if ($request->hasFile('foto')) {
                    if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
                        Storage::disk('public')->delete($petugas->foto);
                    }

                    $filename = 'petugas/profile_' . $petugas->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs('profiles', $filename, 'public');
                    $petugas->foto = $fotoPath;
                }

                $data = [
                    'nama' => $request->nama,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'no_kta' => $request->no_kta,
                    'jabatan' => $request->jabatan,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $petugas->foto,
                    'status' => $request->status,
                ];

                $petugas->update($data);

                $userData =[
                    'username' => $request->username,
                    'email' => $request->email,
                ];

                if ($request->filled('new_password')) {
                    $userData['password'] = Hash::make($request->new_password);
                }

                $user->update($userData);
            });

            return redirect()->route('admin.master-petugas.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Memperbarui Petugas', [
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
            $petugas = Petugas::findOrFail($id);
            $petugas->delete();

            return redirect()->route('admin.master-petugas.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menghapus Perawat', [
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
