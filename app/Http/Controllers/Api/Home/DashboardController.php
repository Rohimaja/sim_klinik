<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function listScheduleDoctor(Request $request)
    {
        $schedule = JadwalDokter::select('jadwal_dokter.id', 'jadwal_dokter.dokter_id', 'jadwal_dokter.poli_id', 'jadwal_dokter.hari', 'jadwal_dokter.jam_mulai', 'jadwal_dokter.jam_akhir', 'jadwal_dokter.keterangan', 'poli.nama as nama_poli')
            ->join('poli', 'poli.id', '=', 'jadwal_dokter.poli_id')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data jadwal dokter berhasil ditampilkan',
            'data' => $schedule
        ]);
    }

    function listDoctor(Request $request)
    {
        $doctors = Dokter::select(
            'dokter.id',
            'dokter.nama',
            DB::raw("CONCAT(
            TIME_FORMAT(jadwal_dokter.jam_mulai, '%H:%i'),
            ' - ',
            TIME_FORMAT(jadwal_dokter.jam_akhir, '%H:%i')
        ) AS time")
        )
            ->join('jadwal_dokter', 'jadwal_dokter.dokter_id', '=', 'dokter.id')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dokter berhasil ditampilkan',
            'data' => $doctors
        ]);
    }


}
