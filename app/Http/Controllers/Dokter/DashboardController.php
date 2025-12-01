<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\AntrianPoli;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'waiting' => AntrianPoli::with('kunjungan')->whereHas('kunjungan', function ($query){
                $query->whereDate('tgl_kunjungan', Carbon::today());
            })->where('status','=', 'menunggu')->count(),
            'done' => AntrianPoli::with('kunjungan')->whereHas('kunjungan', function ($query){
                $query->whereDate('tgl_kunjungan', Carbon::today());
            })->where('status','=', 'selesai')->count(),
            'today' => AntrianPoli::with('kunjungan.pasien','skrining')->whereHas('kunjungan', function ($query){
                $query->whereDate('tgl_kunjungan', Carbon::today());
            })->count(),
            'pasienToday' => AntrianPoli::with('kunjungan.pasien','pemeriksaan')->whereHas('kunjungan', function ($query){
                $query->whereDate('tgl_kunjungan', Carbon::today());
            })->get(),
            // 'pasienToday' => AntrianPoli::with('pasien','poli')->whereDate('tgl_kunjungan', Carbon::today())->get(),
            'pasienDone' => Kunjungan::with('pasien','skrining')->whereDate('tgl_kunjungan', Carbon::today())->where('status', '=','selesai')->limit('10')->get(),

        ];

        $data['pasienToday'] = $data['pasienToday']->map(function ($item) {
            // $item di sini adalah model AntrianPoli
            // Pasien diakses melalui AntrianPoli -> Kunjungan -> Pasien
            
            // Pastikan relasi tidak null
            if ($item->kunjungan && $item->kunjungan->pasien) {
                // Ambil tanggal lahir dan parse menggunakan Carbon
                $tgl_lahir = Carbon::parse($item->kunjungan->pasien->tgl_lahir);
                
                // Tambahkan properti 'umur' ke objek AntrianPoli
                $item->umur = $tgl_lahir->age; 
            } else {
                $item->umur = 'N/A'; // Handle kasus jika relasi tidak ditemukan
            }
            
            return $item;
        });
        
        return view('dokter.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
