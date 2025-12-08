<?php

namespace App\Http\Controllers\Api\Features;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class MedicalHistory extends Controller
{
    function listHistory(Request $request) {
        $request->validate([
            'pasien_id' => 'required'
        ]);

        $pasienId = $request->query('pasien_id');

        $history = Kunjungan::select('kunjungan.id', 'kunjungan.status', 'poli.nama as nama_poli', 'kunjungan.jam_awal', 'kunjungan.jam_akhir', 
        'kunjungan.tgl_kunjungan', 'pasien.nama as nama_pasien', 
        'dokter.nama as nama_dokter')
        ->join('poli', 'poli.id', '=', 'kunjungan.poli_id')
        ->join('pasien', 'pasien.id', '=', 'kunjungan.pasien_id')
        ->join('dokter', 'dokter.id', '=', 'kunjungan.dokter_id')
        ->where('kunjungan.pasien_id', $pasienId)
        ->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data riwayat pasien berhasil ditampilkan',
            'data' => $history
        ]);
    }
}
