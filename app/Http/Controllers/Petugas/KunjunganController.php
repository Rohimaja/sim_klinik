<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Requests\Petugas\Store\StoreKunjungan;
use App\Models\AntrianPoli;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $kunjungan = Kunjungan::with(['pasien','poli','dokter'])->get();
        $pasien = Pasien::select('id','nama','jenis_kelamin','no_rm','tgl_lahir')->get();
        return view('petugas.kunjungan.index', compact('title','kunjungan','pasien'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kunjungan';
        $poli = Poli::all();
        $dokter = Dokter::all();
        $kunjungan = Kunjungan::all();

        return view('petugas.kunjungan.create',compact('title', 'poli','dokter','kunjungan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKunjungan $request)
    {
        $request->merge([
            'nama' => ucwords(trim($request->nama)),
            'tempat_lahir' => ucwords(trim($request->tempat_lahir)),
            'nik' => trim($request->nik),
            'no_bpjs' => trim($request->no_bpjs),
            'keluhan_awal' => trim($request->keluhan_awal),
        ]);

        try {

            $result = DB::transaction(function () use ($request) {

                $no_rm = $this->generateNoRm();

                // $data = $request->validated();

                $data = [
                    'nik' => $request->nik,
                    'nama' => $request->nama,
                    'no_rm' => $no_rm,
                    'jenis_pasien' => $request->jenis_pasien,
                    'no_bpjs' => $request->no_bpjs,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_telp' => $request->no_telp,
                    'alamat' => $request->alamat,
                    'status' => 1,
                ];

                $pasien = Pasien::create($data);

                $kunjungan = Kunjungan::create([
                    'pasien_id' => $pasien->id,
                    'poli_id' => $request->poli_id,
                    'dokter_id' => $request->dokter_id,
                    'tgl_kunjungan' => $request->tgl_kunjungan,
                    'keluhan_awal' => $request->keluhan_awal,
                    'status' => 'menunggu',
                ]);

                $poli = AntrianPoli::create([
                    'kunjungan_id' => $kunjungan->id,
                    'status' => 'menunggu',
                ]);

                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('petugas.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Kunjungan Pasien', [
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
            $kunjungan = Kunjungan::with('pasien.user', 'poli','dokter')->findOrFail($id);

            // Hitung umur
            $tgl_lahir = Carbon::parse($kunjungan->pasien->tgl_lahir);
            $umur = $tgl_lahir->age;

            // Format tanggal lahir & updated_at agar lebih ramah tampil
            $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
            // $updated_at_formatted = Carbon::parse($kunjungan->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

            // Kirim data JSON lengkap
            return response()->json([
                'id' => $kunjungan->id,
                'nama' => $kunjungan->pasien->nama,
                'no_rm' => $kunjungan->pasien->no_rm,
                'status' => $kunjungan->status,
                'tgl_kunjungan' => $kunjungan->tgl_kunjungan,
                'jenis_kelamin' => $kunjungan->pasien->jenis_kelamin,
                'tempat_lahir' => $kunjungan->pasien->tempat_lahir,
                'tgl_lahir' => $tgl_lahir_formatted,
                'umur' => $umur,
                'email' => optional($kunjungan->pasien->user)->email,
                'no_telp' => $kunjungan->pasien->no_telp,
                'alamat' => $kunjungan->pasien->alamat,
                'no_bpjs' => $kunjungan->pasien->no_bpjs,
                'jenis_pasien' => $kunjungan->pasien->jenis_pasien,
                'dokter' => $kunjungan->dokter->nama,
                'poli' => $kunjungan->poli->nama,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kunjungan = Kunjungan::findOrFail($id);
            $kunjungan->delete();

            return redirect()->route('petugas.kunjungan.index')->with([
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

    private function generateNoRm()
    {
        // Ambil nomor RM terakhir
        $last = Pasien::orderBy('no_rm', 'desc')->first();

        if ($last) {
            // Ambil 8 digit terakhir dan ubah ke integer
            $lastNumber = (int) $last->no_rm;

            // Tambah 1, lalu padding jadi 8 digit
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada data sama sekali
            $newNumber = '0001';
        }

        return $newNumber;
    }

    public function updateStatus(Request $request, $id)
    {
        try {

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->status = $request->status;
        $kunjungan->save();

            return back()->with([
                'status' => 'success',
                'message' => 'Status Berhasil diperbarui'
            ]);

        // return back()->with('success', 'Status berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Gagal Menambahkan Kunjungan Pasien', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan data: '
            ]);
        }
    }

     public function listPasien()
    {


        try {

            $pasien = Pasien::select('id','nama','jenis_kelamin','no_rm','tgl_lahir')->get();

            $result = $pasien->map(function ($p) {
                $tgl = Carbon::parse($p->tgl_lahir);
                return [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'no_rm' => $p->no_rm,
                    'jenis_kelamin' => $p->jenis_kelamin,
                    'tgl_lahir' => $tgl->translatedFormat('d F Y'),
                    'umur' => $tgl->age,
                ];
            });

            return response()->json($result);

            // $pasien = Pasien::select('id','nama','jenis_kelamin','no_rm','tgl_lahir')->get();

            // // Hitung umur
            // $tgl_lahir = Carbon::parse($pasien->tgl_lahir);
            // $umur = $tgl_lahir->age;

            // // Format tanggal lahir & updated_at agar lebih ramah tampil
            // $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985
            // // $updated_at_formatted = Carbon::parse($pasien->updated_at)->locale('id')->translatedFormat('d F Y, H:i'). ' WIB'; // Contoh: 2 jam lalu

            // // Kirim data JSON lengkap
            // return response()->json([
            //     'id' => $pasien->id,
            //     'nama' => $pasien->nama,
            //     'no_rm' => $pasien->no_rm,
            //     'jenis_kelamin' => $pasien->jenis_kelamin,
            //     'tgl_lahir' => $tgl_lahir_formatted,
            //     'umur' => $umur,
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'er',
                'message' => $e->getMessage()
                // 'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}
