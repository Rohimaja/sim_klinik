<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KunjunganPasienController extends Controller
{
    public function index()
    {
        return view('petugas.kunjungan.index');
    }

    public function create()
    {
        return view('petugas.kunjungan.create');
    }
}
