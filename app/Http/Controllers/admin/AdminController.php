<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterAdmin;
use App\Http\Requests\Admin\Update\UpdateMasterAdmin;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Admin';
        $admin = Admin::with('user')->get();

        return view('admin.master.admin.index',compact('title','admin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tanbah Admin';
        // $admin = Admin::with('user')->get();

        return view('admin.master.admin.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterAdmin $request)
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
                    'role' => 'admin',
                    'password' => Hash::make($request->username),
                ]);

                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $filename = 'admin/profile_' . $user->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs( 'profiles', $filename, 'public');
                }
                $data = $request->validated();
                $data = [
                    'user_id' => $user->id,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $fotoPath,
                    'is_super_admin' => 0,
                    'status' => $request->status,
                ];

                Admin::create($data);
            });

            return redirect()->route('superadmin.master-admin.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Admin', [
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
        $title = 'Perbarui Admin';
        $admin = Admin::findOrFail($id);

        return view('admin.master.admin.form',compact('title','admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterAdmin $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
        ]);

        try {

            DB::transaction(function () use($request, $id) {

                $admin = Admin::findOrFail($id);
                $user = $admin->user;
                $data = $request->validated();

                if ($request->hasFile('foto')) {
                    if ($admin->foto && Storage::disk('public')->exists($admin->foto)) {
                        Storage::disk('public')->delete($admin->foto);
                    }

                    $filename = 'admin/profile_' . $admin->id . '.' . $request->file('foto')->extension();
                    $fotoPath = $request->file('foto')->storeAs('profiles', $filename, 'public');
                    $admin->foto = $fotoPath;
                }

                $data = [
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'foto' => $admin->foto,
                    'status' => $request->status,
                ];

                $admin->update($data);

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

            return redirect()->route('superadmin.master-admin.index')->with([
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
        //
    }
}
