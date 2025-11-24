<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterPoli;
use App\Http\Requests\Admin\Update\UpdateMasterPoli;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Poli';
        $poli = Poli::all();


        return view('admin.master.poli.index',compact('title','poli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Poli';

        return view('admin.master.poli.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterPoli $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            Poli::create($request->only(['nama', 'keterangan', 'status']));

            return redirect()->route('admin.master-poli.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Di Tambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal tambah Data', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Poli $poli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Poli';
        $poli = Poli::findOrFail($id);

        return view('admin.master.poli.form',compact('title','poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterPoli $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            $poli = Poli::findOrFail($id);

            $poli->update($request->only(['nama', 'keterangan', 'status']));

            return redirect()->route('admin.master-poli.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Di Perbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Perbarui Program Studi', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $poli = Poli::findOrFail($id);
            $poli->delete();

            return redirect()->route('admin.master-poli.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menghapus Data', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}
