<?php

namespace App\Http\Controllers;

use App\Models\Detail_aset_mutasi;
use Illuminate\Http\Request;


class DetailAsetMutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
            'asal_ruangan_id' => 'required',
            'aset_mutasi_id' => 'required',
            'detail_aset_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $cek = Detail_aset_mutasi::where([
                        ['detail_aset_id', '=', $request->detail_aset_id],
                        ['aset_mutasi_id', '=', $request->aset_mutasi_id]
                    ])->count();
                    if ($cek != 0) {
                        $fail('Kode detail aset sudah tersedia di list.');
                    }
                },
            ],
            'tujuan_ruangan_id' => 'required|different:asal_ruangan_id',
            'kondisi' => 'required',
        ]);


        Detail_aset_mutasi::create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detail_aset_mutasi  $detail_aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_aset_mutasi $detail_aset_mutasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail_aset_mutasi  $detail_aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_aset_mutasi $detail_aset_mutasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detail_aset_mutasi  $detail_aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail_aset_mutasi $detail_aset_mutasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_aset_mutasi  $detail_aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_aset_mutasi $detail_aset_mutasi)
    {
        Detail_aset_mutasi::destroy($detail_aset_mutasi->id);
        return redirect()->back();
    }
}
