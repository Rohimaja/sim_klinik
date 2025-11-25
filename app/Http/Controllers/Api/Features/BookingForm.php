<?php

namespace App\Http\Controllers\Api\Features;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Poli;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class BookingForm extends Controller
{
    function addBooking(Request $request)
    {
        $request->validate([
            "pasien_id" => "required",
            "poli_id" => "required",
            "dokter_id" => "required",
            "jam_awal" => "required",
            "jam_akhir" => "required",
            "tgl_kunjungan" => "required|date",
            "keluhan_awal" => "",

        ]);
        $pasienId = $request->pasien_id;
        $poliId = $request->poli_id;
        $dokterId = $request->dokter_id;
        $jamAwal = $request->jam_awal;
        $jamAkhir = $request->jam_akhir;
        $tglKunjungan = $request->tgl_kunjungan;
        $keluhanAwal = $request->keluhan_awal;

        $status = "tidak hadir";

        try {
            DB::begintransaction();

            $kunjunganToday = Kunjungan::where('tgl_kunjungan', $tglKunjungan, )->orderBy('no_antrian', 'desc')->first();

            if ($kunjunganToday) {
                $lastNumber = intval($kunjunganToday->no_antrian);

                $newNumber = $lastNumber + 1;

                $noAntrian = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            } else {
                $noAntrian = "0001";
            }

            $kunjungan = Kunjungan::create([
                'pasien_id' => $pasienId,
                'poli_id' => $poliId,
                'dokter_id' => $dokterId,
                'no_antrian' => $noAntrian,
                'jam_awal' => $jamAwal,
                'jam_akhir' => $jamAkhir,
                'tgl_kunjungan' => $tglKunjungan,
                'keluhan_awal' => $keluhanAwal,
                'status' => $status,
            ]);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data antrian berhasil diunggah.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    function listDoctor(Request $request)
    {
        $doctors = Dokter::select('id', 'nama')->get();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data dokter berhasil ditampilkan',
                'data' => $doctors
            ]
        );
    }

    function listPoli(Request $request)
    {
        $polis = Poli::select('id', 'nama')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data poli berhasil ditampilkan',
            'data' => $polis
        ]);
    }

    function listScheduleDoctor(Request $request)
    {
        $schedule = JadwalDokter::select('id', 'dokter_id', 'poli_id', 'hari', 'jam_mulai', 'jam_akhir', 'keterangan')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data jadwal dokter berhasil ditampilkan',
            'data' => $schedule
        ]);
    }
}
