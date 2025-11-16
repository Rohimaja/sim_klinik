<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterTindakan;
use App\Http\Requests\Admin\Update\UpdateMasterTindakan;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Tindakan';
        $tindakan = Tindakan::all();

        return view('admin.master.tindakan.index',compact('title','tindakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Tindakan';

        return view('admin.master.tindakan.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterTindakan $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            Tindakan::create($request->only(['nama', 'keterangan', 'tarif', 'status']));

            return redirect()->route('admin.master-tindakan.index')->with([
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
    public function show(Tindakan $tindakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Tindakan';
        $tindakan = Tindakan::findOrFail($id);

        return view('admin.master.tindakan.form',compact('title','tindakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterTindakan $request, $id)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {
            $tindakan = Tindakan::findOrFail($id);

            $tindakan->update($request->only(['nama', 'tarif', 'keterangan', 'status']));

            return redirect()->route('admin.master-tindakan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Di Perbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Perbarui Tindakan', [
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
            $tindakan = Tindakan::findOrFail($id);
            $tindakan->delete();

            return redirect()->route('admin.master-tindakan.index')->with([
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
