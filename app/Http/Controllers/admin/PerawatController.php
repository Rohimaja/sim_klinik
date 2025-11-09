<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterPerawat;
use App\Http\Requests\Admin\Update\UpdateMasterPerawat;
use App\Models\Perawat;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Perawat';
        $perawat = Perawat::with('user','poli')->get();

        return view('admin.master.perawat.index',compact('title','perawat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Perawat';
        $poli = Poli::all();

        return view('admin.master.perawat.form',compact('title','poli'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterPerawat $request)
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
                    'role' => 'perawat',
                    'password' => Hash::make($request->username),
                ]);

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $filename = 'perawat/profile_' . $user->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs( 'profiles', $filename, 'public');
                }
                $data = $request->validated();
                $data = [
                    'user_id' => $user->id,
                    'poli_id' => $request->poli_id,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'no_nira' => $request->no_nira,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $fotoPath,
                    'status' => $request->status,
                ];

                Perawat::create($data);
            });

            return redirect()->route('admin.master-perawat.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Perawat', [
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
        $title = 'Perbarui Perawat';
        $perawat = Perawat::findOrFail($id);
        $poli = Poli::all();

        return view('admin.master.perawat.form',compact('title','perawat','poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPerawat $request, $id)
    {
       $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use($request, $id) {

                $perawat = Perawat::findOrFail($id);
                $user = $perawat->user;
                $data = $request->validated();

                if ($request->hasFile('foto')) {
                    if ($perawat->foto && Storage::disk('public')->exists($perawat->foto)) {
                        Storage::disk('public')->delete($perawat->foto);
                    }

                    $filename = 'perawat/profile_' . $perawat->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs('profiles', $filename, 'public');
                    $perawat->foto = $fotoPath;
                }

                $data = [
                    'poli_id' => $request->poli_id,
                    'no_str' => $request->no_str,
                    'no_sip' => $request->no_sip,
                    'no_nira' => $request->no_nira,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $perawat->foto,
                    'status' => $request->status,
                ];

                $perawat->update($data);

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

            return redirect()->route('admin.master-perawat.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Memperbarui Perawat', [
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
            $perawat = Perawat::findOrFail($id);
            $perawat->delete();

            return redirect()->route('admin.master-perawat.index')->with([
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
