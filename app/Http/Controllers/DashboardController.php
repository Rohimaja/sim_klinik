<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DetailPresensi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Presensi;
use App\Models\Prodi;


use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        $data = [
        'title' => 'Dashboard',
        ];

        return view('admin.index',$data);
    }

        public function indexDokter()
    {

        $data = [
            'title' => 'Dashboard',
        ];

        return view('dokter.index', $data);
    }

    public function indexPetugas(){
        $title = 'Dashboard';

        return view('petugas.index',compact('title'));
    }

    public function indexPerawat(){
        $title = 'Dashboard';

        return view('perawat.index',compact('title'));
    }

    public function indexPasien(){
        $title = 'Dashboard';

        return view('pasien.index',compact('title'));
    }

    public function indexSuperAdmin(){
        $title = 'Dashboard';

        return view('superadmin.index',compact('title'));
    }
}
