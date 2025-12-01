<?php

namespace App\Http\Controllers\Api\Features;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class PracticeSchedule extends Controller
{
    function listPoli(Request $request)
    {
        $polis = Poli::select('id', 'nama', 'status')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data poli berhasil ditampilkan',
            'data' => $polis
        ]);
    }

    function detailListPoli(Request $request)
    {
        $request->validate([
            'id_poli' => 'required'
        ]);

        $idPoli = $request->query('id_poli');

        $schedule = JadwalDokter::select('jadwal_dokter.id', 'jadwal_dokter.dokter_id', 'jadwal_dokter.poli_id', 'jadwal_dokter.hari', 'jadwal_dokter.jam_mulai', 
        'jadwal_dokter.jam_akhir', 'jadwal_dokter.keterangan', 'poli.nama as nama_poli', 'dokter.nama', 'dokter.spesialisasi')
            ->join('poli', 'poli.id', '=', 'jadwal_dokter.poli_id')
            ->join('dokter', 'dokter.id', '=', 'jadwal_dokter.dokter_id')
            ->where('jadwal_dokter.poli_id', $idPoli)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data jadwal dokter berhasil ditampilkan',
            'data' => $schedule
        ]);
    }
}
