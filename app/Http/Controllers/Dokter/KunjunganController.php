<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\AntrianPoli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Tambah Kunjungan Pasien";
        $kunjungan = AntrianPoli::with(['kunjungan'])->get();
        $kunjungan = $kunjungan->map(function ($item) {
            $tgl_lahir = Carbon::parse($item->kunjungan->pasien->tgl_lahir);
            $item->umur = $tgl_lahir->age;
            return $item;
        });
        return view('dokter.kunjungan.index', compact('title','kunjungan'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $title = 'Tambah Kunjungan';
        // $poli = Poli::all();
        // $dokter = Dokter::all();
        // $kunjungan = Kunjungan::all();

        return view('petugas.kunjungan.form',compact('title', 'pasien','mode'));
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
                $no_antrian = $this->generateNoAntrian($request->tgl_kunjungan);

                $nik = Pasien::where('nik', $request->nik)->first();

                // $data = $request->validated();

                if (!$nik) {

                    $user = User::create([
                        'email' => $request->email,
                        'role' => 'pasien'
                    ]);

                    $data = [
                        'user_id' => $user->id,
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

                } else {

                    // Pasien lama dipakai kembali
                    $pasien = $nik;
                }

                    // Cek apakah pasien sudah memiliki kunjungan aktif di tanggal yang sama
                    $cekAntrian = Kunjungan::where('pasien_id', $pasien->id)
                        ->whereDate('tgl_kunjungan', $request->tgl_kunjungan)
                        ->where('status', '!=', 'selesai')
                        ->exists();

                    if ($cekAntrian) {
                        return back()
                            ->withErrors(['nik' => 'Pasien sudah memiliki kunjungan aktif pada tanggal ini.'])
                            ->withInput();
                    }

                $kunjungan = Kunjungan::create([
                    'pasien_id' => $pasien->id,
                    'poli_id' => $request->poli_id,
                    'no_antrian' => $no_antrian,
                    'dokter_id' => $request->dokter_id,
                    'tgl_kunjungan' => $request->tgl_kunjungan,
                    'jam_awal' => $request->jam_awal,
                    'jam_akhir' => $request->jam_akhir,
                    'keluhan_awal' => $request->keluhan_awal,
                    'status' => 'menunggu',
                ]);

                    // 2. Cek apakah dokter benar dari poli tsb
                    $dokterValid = Dokter::where('id', $request->dokter_id)
                        ->where('poli_id', $request->poli_id)
                        ->exists();

                    if (!$dokterValid) {
                        return back()->withErrors([
                            'dokter_id' => 'Dokter tidak sesuai dengan poli yang dipilih.',
                        ])->withInput();
                    }

                AntrianPoli::create([
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
            $antrian = AntrianPoli::with('kunjungan')->findOrFail($id);

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
                'keluhan' => $antrian->kunjungan->skrining->keluhan_utama,
                'tensi' => $antrian->kunjungan->skrining->tensi,
                'suhu' => $antrian->kunjungan->skrining->suhu,
                'bb' => $antrian->kunjungan->skrining->berat_badan,
                'tb' => $antrian->kunjungan->skrining->tinggi_badan,
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
        $title = 'Update Pemeriksaan Pasien';
        // $poli = Poli::all();
        // $dokter = Dokter::all();
        $kunjungan = AntrianPoli::with('kunjungan')->findOrFail($id);
        $pasien = $kunjungan->kunjungan->pasien; // relasi pasien

        return view('dokter.kunjungan.form', compact('title','kunjungan', 'pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $result = DB::transaction(function () use ($request, $id) {
                $kunjungan = Kunjungan::with('pasien.user','dokter','poli')->findOrFail($id);

                    // Cek apakah pasien sudah memiliki kunjungan aktif di tanggal yang sama
                    $cekAntrian = Kunjungan::where('pasien_id', $request->pasien_id)
                        ->whereDate('tgl_kunjungan', $request->tgl_kunjungan)
                        ->where('id', '!=', $id) // penting!
                        ->where('status', '!=', 'selesai')
                        ->exists();

                    if ($cekAntrian) {
                        return back()
                            ->withErrors(['nik' => 'Pasien sudah memiliki kunjungan aktif pada tanggal ini.'])
                            ->withInput();
                    }
                    // 2. Cek apakah dokter benar dari poli tsb
                    $dokterValid = Dokter::where('id', $request->dokter_id)
                        ->where('poli_id', $request->poli_id)
                        ->exists();

                    if (!$dokterValid) {
                        return back()->withErrors([
                            'dokter_id' => 'Dokter tidak sesuai dengan poli yang dipilih.',
                        ])->withInput();
                    }

                $kunjungan->update([
                    'pasien_id'     => $request->pasien_id,
                    'poli_id'       => $request->poli_id,
                    'dokter_id'     => $request->dokter_id,
                    'tgl_kunjungan' => $request->tgl_kunjungan,
                    'jam_awal'      => $request->jam_awal,
                    'jam_akhir'     => $request->jam_akhir,
                    'keluhan_awal'  => $request->keluhan_awal,
                ]);


                return true;
            });

            if ($result !== true) {
                return $result;
            }

            return redirect()->route('petugas.kunjungan.index')->with([
                'status' => 'success',
                'message' => 'Data Berhasil Diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui Presensi', [
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
}
