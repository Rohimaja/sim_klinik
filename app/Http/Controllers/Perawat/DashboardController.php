<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
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
        $today = Carbon::today();

        // Ambil pasien hari ini + hitung umur
        $pasienToday = Kunjungan::with('pasien','skrining')
            ->whereDate('tgl_kunjungan', $today)
            ->get()
            ->map(function ($item) {
                $item->umur = Carbon::parse($item->pasien->tgl_lahir)->age;
                return $item;
            });

        // Ambil skrining (dipanggil hari ini)
        $skrining = $pasienToday->where('status', 'dipanggil');

        // Kirim ke view
        $data = [
            'title' => 'Dashboard',
            'before' => Kunjungan::whereDate('tgl_kunjungan', $today)
                            ->whereIn('status', ['menunggu', 'tidak hadir'])
                            ->count(),

            'do' => Kunjungan::whereDate('tgl_kunjungan', $today)
                            ->where('status', 'dipanggil')
                            ->count(),

            'pasien' => Pasien::count(),

            'done' => Kunjungan::whereDate('tgl_kunjungan', $today)
                            ->where('status', 'selesai')
                            ->count(),

            'pasienToday' => $pasienToday,
            'skrining' => $skrining,
        ];

        $title = 'Dashboard';
        return view('perawat.index',$data);
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
