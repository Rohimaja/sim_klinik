<?php

namespace App\Http\Controllers\Petugas;

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

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = [
            'title' => 'Dashboard',
            'before' => Kunjungan::with('pasien')->whereDate('tgl_kunjungan', Carbon::today())->where('status', 'menunggu')->count(),
            'do' => Kunjungan::with('pasien')->whereDate('tgl_kunjungan', Carbon::today())->where('status', 'dipanggil')->count(),
            'pasienBaru' => Pasien::whereMonth('created_at', $currentMonth)
                                        ->whereYear('created_at', $currentYear)
                                        ->count(),
            // 'aktif' => Pasien::count(),
            'menunggu' => Kunjungan::with('pasien')->whereDate('tgl_kunjungan', Carbon::today())->where('status', 'menunggu')->count(),
            'aktif' => Kunjungan::with('pasien')->whereDate('tgl_kunjungan', Carbon::today())->where('status', '!=', 'tidak hadir')->count(),
            'done' => Kunjungan::with('pasien')->whereDate('tgl_kunjungan', Carbon::today())->where('status', 'selesai')->count(),
            'today' => Kunjungan::with('pasien','skrining')->whereDate('tgl_kunjungan', Carbon::today())->count(),
            'pasienToday' => Kunjungan::with('pasien','poli')->whereDate('tgl_kunjungan', Carbon::today())->get(),
            'pasienDone' => Kunjungan::with('pasien','skrining')->whereDate('tgl_kunjungan', Carbon::today())->where('status', '=','selesai')->limit('10')->get(),

        ];
        $title = 'Dashboard';
        return view('petugas.index',$data);
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
