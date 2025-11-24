<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KunjunganPerawatController extends Controller
{
    public function index()
    {
        return view('perawat.kunjungan.index');
    }
    
    public function create()
    {
        return view('perawat.kunjungan.create');
    }
}
