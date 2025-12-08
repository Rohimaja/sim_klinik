<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dokter\Store\StorePemeriksaan;
use App\Http\Requests\Dokter\Update\UpdatePemeriksaan;
use App\Models\AntrianPoli;
use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KunjunganController extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Tambah Kunjungan Pasien";
        $antrian = AntrianPoli::with(['kunjungan'])->get();
        $kunjungan = $antrian->map(function ($item) {
            $tgl_lahir = Carbon::parse($item->kunjungan->pasien->tgl_lahir);
            $item->umur = $tgl_lahir->age;
            return $item;
        });
        return view('dokter.kunjungan.index', compact('title','antrian'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $id)
    {
        $title = 'Tambah Kunjungan';
        $antrian = AntrianPoli::with('kunjungan.pasien')->findOrFail($id);
        $pasien = $antrian->kunjungan->pasien;
        $skrining = $antrian->kunjungan->skrining;

        return view('dokter.kunjungan.form',compact('title','antrian','pasien','skrining'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePemeriksaan $request)
    {
        $request->merge([
            'diagnosa' => ucwords(trim($request->diagnosa)),
            'tindakan' => ucwords(trim($request->tindakan)),
            'catatan' => ucwords(trim($request->catatan)),
        ]);

        try {

            $result = DB::transaction(function () use ($request) {

                $dokter = Auth::user()->dokter;


                $data = [
                    'dokter_id'         => $dokter->id,
                    'antrian_poli_id'   => $request->antrian_poli_id, // ← langsung ambil dari request
                    'diagnosa'          => $request->diagnosa,
                    'tindakan'          => $request->tindakan,
                    'catatan'           => $request->catatan,
                    'tgl_periksa'       => $request->tgl_periksa,
                ];

                Pemeriksaan::create($data);

                $antrian = AntrianPoli::find($request->antrian_poli_id);
                $antrian->status = 'selesai';
                $antrian->save();

                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('dokter.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Pemeriksaan Pasien', [
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
            $antrian = AntrianPoli::with('kunjungan.skrining','kunjungan.pasien.user')->findOrFail($id);

            // Hitung umur
            $tgl_lahir = Carbon::parse($antrian->kunjungan->pasien->tgl_lahir);
            $umur = $tgl_lahir->age;

            // Format tanggal lahir & updated_at agar lebih ramah tampil
            $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
            // $updated_at_formatted = Carbon::parse($antrian->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

            // Kirim data JSON lengkap
            return response()->json([
                'id' => $antrian->id,
                'nama' => $antrian->kunjungan->pasien->nama,
                'nik' => $antrian->kunjungan->pasien->nik,
                'no_rm' => $antrian->kunjungan->pasien->no_rm,
                'status' => $antrian->status,
                'tgl_kunjungan' => $antrian->kunjungan->tgl_kunjungan,
                'jenis_kelamin' => $antrian->kunjungan->pasien->jenis_kelamin,
                'tgl_lahir' => $tgl_lahir_formatted,
                'umur' => $umur,
                'email' => optional($antrian->kunjungan->pasien->user)->email,
                        // Skrining aman meski skrining = null
                'keluhan' => optional($antrian->kunjungan->skrining)->keluhan_utama,
                'tensi' => optional($antrian->kunjungan->skrining)->tensi,
                'suhu' => optional($antrian->kunjungan->skrining)->suhu,
                'bb' => optional($antrian->kunjungan->skrining)->berat_badan,
                'tb' => optional($antrian->kunjungan->skrining)->tinggi_badan,
                // 'keluhan' => $antrian->kunjungan->skrining->keluhan_utama,
                // 'tensi' => $antrian->kunjungan->skrining->tensi,
                // 'suhu' => $antrian->kunjungan->skrining->suhu,
                // 'bb' => $antrian->kunjungan->skrining->berat_badan,
                // 'tb' => $antrian->kunjungan->skrining->tinggi_badan,
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
        $title = 'Perbarui Pemeriksaan Pasien';
        $pemeriksaan = Pemeriksaan::with('antrian.kunjungan.pasien')->findOrFail($id);
        $antrian = $pemeriksaan->antrian;
        $pasien = $antrian->kunjungan->pasien;
        $skrining = $antrian->kunjungan->skrining;

        return view('dokter.kunjungan.form', compact('title','pemeriksaan', 'pasien','antrian','skrining'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePemeriksaan $request, string $id)
    {
        try {

            $result = DB::transaction(function () use ($request, $id) {
                $pemeriksaan = Pemeriksaan::with('antrian.kunjungan.pasien')->findOrFail($id);

                $dokter = Auth::user()->dokter;

                $pemeriksaan->update([
                    'dokter_id'         => $dokter->id,
                    'diagnosa'          => $request->diagnosa,
                    'tindakan'          => $request->tindakan,
                    'catatan'           => $request->catatan,
                    'tgl_periksa'       => $request->tgl_periksa,
                ]);

                $antrian = AntrianPoli::find($request->antrian_poli_id);
                $antrian->status = 'selesai';
                $antrian->save();


                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('dokter.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui Pemeriksaan', [
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
            $antrian = AntrianPoli::findOrFail($id);
            $antrian->delete();

            return redirect()->route('dokter.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menghapus Data Kunjungan', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: '
            ]);
        }
    }

    public function updateStatus($id)
    {
        try {

            $antrian = AntrianPoli::findOrFail($id);
            $antrian->status = 'dipanggil';
            $antrian->save();

            return redirect()->route('dokter.kunjungan.create', $id);

            // return back()->with([
            //     'status' => 'success',
            //     'message' => 'Status Berhasil diperbarui'
            // ]);

        // return back()->with('success', 'Status berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Gagal Perbarui Status Pasien', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan data: '
            ]);
        }
    }

    public function getFilterKunjungan(Request $request)
    {
        $status = $request->query('filter-status');
        $tgl = $request->query('filter-tanggal');

        $query = AntrianPoli::query()->with('kunjungan.skrining','pemeriksaan');

        if ($status) {
            $query->where('status', $status);
        }

        if (!empty($tgl)) {
            $query->whereHas('kunjungan', function ($q) use ($tgl) {
                $q->whereDate('tgl_kunjungan', $tgl);
            });
        }

        $antrian = $query->get();

        $antrian = $antrian->map(function ($item) {
            $tgl_lahir = Carbon::parse($item->kunjungan->pasien->tgl_lahir);
            $item->umur = $tgl_lahir->age;
            return $item;
        });

        return response()->json($antrian);

            // return response()->json([
            //     'id' => $kunjungan->id,
            //     'nama' => $kunjungan->pasien->nama,
            //     'nik' => $kunjungan->pasien->nik,
            //     'no_rm' => $kunjungan->pasien->no_rm,
            //     'status' => $kunjungan->status,
            //     'tgl_kunjungan' => $kunjungan->tgl_kunjungan,
            //     'jenis_kelamin' => $kunjungan->pasien->jenis_kelamin,
            //     'tgl_lahir' => $tgl_lahir_formatted,
            //     'umur' => $umur,
            //     'email' => optional($kunjungan->pasien->user)->email,
            //     'keluhan_awal' => $kunjungan->keluhan_awal,
            // ]);
    }
}
