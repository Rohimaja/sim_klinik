<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterObat;
use App\Http\Requests\Admin\Update\UpdateMasterObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Obat';
        $obat = Obat::all();

        return view('admin.master.obat.index',compact('title','obat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Obat';

        return view('admin.master.obat.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterObat $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            Obat::create($request->only(['nama','jenis_obat','stok','harga', 'keterangan', 'status']));

            return redirect()->route('admin.master-obat.index')->with([
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
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Obat';
        $obat = Obat::findOrFail($id);

        return view('admin.master.obat.form',compact('title','obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterObat $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            $obat = Obat::findOrFail($id);

            $obat->update($request->only(['nama','jenis_obat','stok','harga', 'keterangan', 'status']));

            return redirect()->route('admin.master-obat.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Di Perbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Perbarui Obat', [
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
    public function destroy(string $id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

            return redirect()->route('admin.master-obat.index')->with([
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
