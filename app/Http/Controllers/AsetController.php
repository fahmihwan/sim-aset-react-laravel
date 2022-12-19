<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Master_data/Aset/Index', [
            'asets' => Aset::with('kategori')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Master_data/Aset/Create', [
            'kategories' => Kategori::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
        ]);



        Aset::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
        ]);
        return redirect('/aset');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset $aset)
    {

        return Inertia::render('Master_data/Aset/Edit', [
            'data' => $aset,
            'kategories' => Kategori::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
        ]);

        Aset::where('id', $id)->update([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect('/aset');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Aset::destroy($id);
        return redirect()->back();
    }
}
