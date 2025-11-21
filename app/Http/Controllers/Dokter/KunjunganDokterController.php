<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KunjunganDokterController extends Controller
{
    public function index()
    {
        return view('dokter.kunjungan.index');
    }
}
