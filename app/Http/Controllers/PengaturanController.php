<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function profile()
    {
        return view('pengaturan.profile', [
            'user' => Auth::user()
        ]);
    }

    public function password()
    {
        return view('pengaturan.password');
    }

    public function tampilan()
    {
        return view('pengaturan.tampilan');
    }
}
