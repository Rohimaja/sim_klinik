<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perawat\Store\StoreSkrining;
use App\Http\Requests\Perawat\Update\UpdateSkrining;
use App\Models\AntrianPoli;
use App\Models\Kunjungan;
use App\Models\Skrining;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        $kunjungan = Kunjungan::with('pasien','skrining')->get();
        $kunjungan = $kunjungan->map(function ($item) {
            $tgl_lahir = Carbon::parse($item->pasien->tgl_lahir);
            $item->umur = $tgl_lahir->age;
            return $item;
        });
        return view('perawat.kunjungan.index', compact('title','kunjungan'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $id)
    {
        $title = 'Tambah Kunjungan';
        $kunjungan = Kunjungan::with('pasien')->findOrFail($id);
        $tgl_lahir = Carbon::parse($kunjungan->pasien->tgl_lahir);
        $umur = $tgl_lahir->age;
        // $poli = Poli::all();
        // $dokter = Dokter::all();
        // $kunjungan = Kunjungan::all();

        return view('perawat.kunjungan.form',compact('title','kunjungan','umur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkrining $request)
    {
        $request->merge([
            'suhu' => trim($request->suhu),
            'berat_badan' => trim($request->berat_badan),
            'tinggi_badan' => trim($request->tinggi_badan),
            'keluhan_utama' => trim($request->keluhan_utama),
        ]);

        try {

            $result = DB::transaction(function () use ($request) {

                $perawat = Auth::user()->perawat;
                $tensi = $request->sistol . '/' . $request->diastolik;


                // $data = $request->validated();

                $data = [
                    'perawat_id'      => $perawat->id,
                    'kunjungan_id'    => $request->kunjungan_id, // ← langsung ambil dari request
                    'tensi'           => $tensi,
                    'suhu'            => $request->suhu,
                    'berat_badan'     => $request->berat_badan,
                    'tinggi_badan'    => $request->tinggi_badan,
                    'keluhan_utama'   => $request->keluhan_utama,
                ];

                Skrining::create($data);

                $kunjungan = Kunjungan::find($request->kunjungan_id);
                $kunjungan->status = 'selesai';
                $kunjungan->save();

                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('perawat.kunjungan.index')->with([
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
            $kunjungan = Kunjungan::with('pasien')->findOrFail($id);

            // Hitung umur
            $tgl_lahir = Carbon::parse($kunjungan->pasien->tgl_lahir);
            $umur = $tgl_lahir->age;

            // Format tanggal lahir & updated_at agar lebih ramah tampil
            $tgl_lahir_formatted = $tgl_lahir->translatedFormat('d F Y'); // Contoh: 15 Maret 1985

            // Kirim data JSON lengkap
            return response()->json([
                'id' => $id,
                'nama' => $kunjungan->pasien->nama,
                'nik' => $kunjungan->pasien->nik,
                'no_rm' => $kunjungan->pasien->no_rm,
                'status' => $kunjungan->status,
                'tgl_kunjungan' => $kunjungan->tgl_kunjungan,
                'jenis_kelamin' => $kunjungan->pasien->jenis_kelamin,
                'tgl_lahir' => $tgl_lahir_formatted,
                'umur' => $umur,
                'email' => optional($kunjungan->pasien->user)->email,
                'keluhan_awal' => $kunjungan->keluhan_awal,
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
        $title = 'Perbarui Kunjungan';
        $skrining = Skrining::with('kunjungan.pasien')->findOrFail($id);
        $kunjungan = $skrining->kunjungan;
        $tgl_lahir = Carbon::parse($skrining->kunjungan->pasien->tgl_lahir);
        $umur = $tgl_lahir->age;
        $sistol = null;
        $diastolik = null;

        if ($skrining->tensi) {
            [$sistol, $diastolik] = explode('/', $skrining->tensi);
        }

        return view('perawat.kunjungan.form',compact('title','kunjungan','umur','skrining','sistol','diastolik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkrining $request, $id)
    {
        try {

            $result = DB::transaction(function () use ($request, $id) {
                $skrining = Skrining::with('kunjungan.pasien')->findOrFail($id);

                $perawat = Auth::user()->perawat;
                $tensi = $request->sistol . '/' . $request->diastolik;

                $skrining->update([
                    'perawat_id'      => $perawat->id,
                    'tensi'           => $tensi,
                    'suhu'            => $request->suhu,
                    'berat_badan'     => $request->berat_badan,
                    'tinggi_badan'    => $request->tinggi_badan,
                    'keluhan_utama'   => $request->keluhan_utama,
                ]);


                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('perawat.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui Skrining', [
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

    public function updateStatus($id)
    {
        try {

            $kunjungan = Kunjungan::findOrFail($id);
            $kunjungan->status = 'dipanggil';
            $kunjungan->save();

            return redirect()->route('perawat.kunjungan.create', $id);

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
        $status = $request->query('status');
        $tgl = $request->query('tgl_kunjungan');

        $query = Kunjungan::query()->with('pasien','skrining');

        if ($status) {
            $query->where('status', $status);
        }

        if ($tgl) {
            $query->where('tgl_kunjungan', $tgl);
        }

        $kunjungan = $query->get();

        return response()->json($kunjungan);
    }
}
