<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Aset_masuk;
use App\Models\Detail_aset;
use App\Models\Gudang;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AsetMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Aset_masuk/Index', [
            'aset_masuk' => Aset_masuk::latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode = '#AST' .  Carbon::now()->format('dmyHis');
        return Inertia::render('Aset_masuk/Create', [
            'kode' => $kode
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
            'kode' => 'required',
            'keterangan' => 'required',
            'penerima' => 'required',
            'tanggal_masuk' => 'required',
        ]);

        Aset_masuk::create([
            'kode_masuk' => $request->kode,
            'user_id' => auth()->user()->id,
            'keterangan' => $request->keterangan,
            'asal_aset' => $request->penerima,
            'tanggal_masuk' => $request->tanggal_masuk,
            'verifikasi' => false
        ]);

        return redirect('/aset_masuk');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset_masuk  $aset_masuk
     * @return \Illuminate\Http\Response
     */
    public function show(Aset_masuk $aset_masuk)
    {
        $detail_asset = Detail_aset::with(['aset', 'ruangan'])
            ->where('aset_masuk_id', $aset_masuk->id)
            ->orderBY('kode_detail_aset', 'DESC')->get();


        // return Gudang::with('ruangan')->latest()->get();
        return Inertia::render('Aset_masuk/Show', [
            'aset_masuk' => $aset_masuk,
            'aset_id' => Aset::latest()->get(),
            'ruangan_id' => Gudang::with('ruangan')->latest()->get(),
            'detail_aset_masuk' => $detail_asset
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset_masuk  $aset_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        Aset_masuk::where('id', $id)->update([
            'verifikasi' => $request->verifikasi
        ]);

        return redirect()->back();
    }
}
