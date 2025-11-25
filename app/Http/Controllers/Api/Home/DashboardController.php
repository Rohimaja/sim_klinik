<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
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
}
