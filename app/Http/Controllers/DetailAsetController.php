<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Detail_aset;
use Illuminate\Http\Request;

class DetailAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Detail_aset/Index', [
            'detail_aset' => Aset_masuk::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'kode_detail_aset' => 'required',
            'aset_id' => 'required',
            'ruangan_id' => 'required',
            'aset_masuk_id' => 'required',
        ]);
        Detail_aset::create($validated);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detail_aset  $detail_aset
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_aset $detail_aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail_aset  $detail_aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_aset $detail_aset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detail_aset  $detail_aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail_aset $detail_aset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_aset  $detail_aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_aset $detail_aset)
    {
        Detail_aset::destroy($detail_aset->id);
        return redirect()->back();
    }
}
