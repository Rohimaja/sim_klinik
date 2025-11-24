<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreMasterJadwal;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Jadwal Dokter';
        $jadwal = JadwalDokter::with( ['dokter', 'poli'])->orderByDesc('id')->get();

        return view('admin.master.jadwal-dokter.index',compact('title','jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Master Dokter';
        $dokter = Dokter::select('id','nama')->get();
        $poli = Poli::select('id','nama')->get();

        return view('admin.master.jadwal-dokter.form',compact('title','dokter','poli'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasterJadwal $request)
    {
        $request->merge([
            // 'keterangan' => ucwords(trim($request->keterangan)),
        ]);

        try {

            DB::transaction(function () use ($request) {
                $data = [
                    'dokter_id' => $request->dokter_id,
                    'poli_id' => $request->poli_id,
                    'hari' => $request->hari,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_akhir' => $request->jam_akhir,
                    'keterangan' => $request->keterangan,
                ];

                JadwalDokter::create($data);
            });

            return redirect()->route('admin.master-jadwal.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Jadwal Dokter', [
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
    public function show(JadwalDokter $jadwalDokter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Jadwal Dokter';
        $dokter = Dokter::select('id','nama')->get();
        $poli = Poli::select('id','nama')->get();
        $jadwal = JadwalDokter::findOrFail($id);

        return view('admin.master.jadwal-dokter.form',compact('title','dokter','poli','jadwal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalDokter $jadwalDokter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jadwal = JadwalDokter::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('admin.master-jadwal.index')->with([
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
