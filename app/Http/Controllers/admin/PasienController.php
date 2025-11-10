<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterPasien;
use App\Http\Requests\Admin\Update\UpdateMasterPasien;
use App\Models\Pasien;
use App\Models\User;
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
                    'nama' => $request->nama,
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
        //
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
                    'nama' => $request->nama,
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
        //
    }

    private function generateNoRm()
    {
        // Ambil nomor RM terakhir
        $last = Pasien::orderBy('no_rm', 'desc')->first();

        if ($last) {
            // Ambil 8 digit terakhir dan ubah ke integer
            $lastNumber = (int) $last->no_rm;

            // Tambah 1, lalu padding jadi 8 digit
            $newNumber = str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data sama sekali
            $newNumber = '0001';
        }

        return $newNumber;
    }

}
