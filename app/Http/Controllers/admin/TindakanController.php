<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Tindakan';
        $tindakan = Tindakan::all();

        return view('admin.master.tindakan.index',compact('title','tindakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Tindakan';

        return view('admin.master.tindakan.create',compact('title'));
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
    public function show(Tindakan $tindakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Perbarui Tindakan';
        $tindakan = Tindakan::findOrFail($id);

        return view('admin.master.tindakan.edit',compact('title','tindakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tindakan $tindakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tindakan $tindakan)
    {
        //
    }
}
