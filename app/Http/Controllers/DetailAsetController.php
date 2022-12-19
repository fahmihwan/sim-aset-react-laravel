<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Detail_aset;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_detail_aset' => 'required|unique:detail_asets',
            'aset_id' => 'required',
            'ruangan_id' => 'required',
            'aset_masuk_id' => 'required',
        ]);

        Detail_aset::create($validated);

        return redirect()->back()->with([
            'type' => 'fail',
            'message' => 'User has been updated'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_aset  $detail_aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_aset $detail_aset)
    {

        Detail_aset::where('id', $detail_aset->id)->forceDelete();
        return redirect()->back();
    }
}
