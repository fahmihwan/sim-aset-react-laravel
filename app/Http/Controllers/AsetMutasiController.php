<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Aset_mutasi;
use App\Models\Detail_aset;
use App\Models\Detail_aset_mutasi;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Termwind\render;

class AsetMutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Aset_mutasi/Index', [
            'aset_mutasi' => Aset_mutasi::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode = '#MT' .  Carbon::now()->format('dmyHis');
        return Inertia::render('Aset_mutasi/Create', [
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
            'tanggal_mutasi' => 'required',
        ]);

        Aset_mutasi::create([
            'kode_mutasi' => $request->kode,
            'user_id' => auth()->user()->id,
            'keterangan' => $request->keterangan,
            'tanggal_mutasi' => $request->tanggal_mutasi,
            'verifikasi' => false
        ]);

        return redirect('/aset_mutasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset_mutasi  $aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function show(Aset_mutasi $aset_mutasi)
    {

        $detail_asset = Detail_aset_mutasi::with([
            'detail_aset:id,kode_detail_aset,aset_id',
            'detail_aset.aset:id,nama',
            'asal_ruangan:id,ruangan',
            'tujuan_ruangan:id,ruangan'
        ])
            ->where('aset_mutasi_id', $aset_mutasi->id)
            ->latest()
            ->get();

        return Inertia::render('Aset_mutasi/Show', [
            'aset_mutasi' => $aset_mutasi,
            'ruangans' => Ruangan::latest()->get(),
            'detail_aset_mutasi' => $detail_asset,
            'detail_aset_id' => Detail_aset::with('aset')->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset_mutasi  $aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset_mutasi $aset_mutasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset_mutasi  $aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset_mutasi $aset_mutasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset_mutasi  $aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset_mutasi $aset_mutasi)
    {
        //
    }

    function get_detail_aset($id)
    {
        return Detail_aset::with(['ruangan', 'aset'])->where('ruangan_id', $id)->get();
    }
}
