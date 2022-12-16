<?php

namespace App\Http\Controllers;

use App\Models\Detail_aset_penghapusan;
use Illuminate\Http\Request;

class DetailAsetPenghapusanController extends Controller
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
            'aset_penghapusan_id' => 'required',
            'detail_aset_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $cek = Detail_aset_penghapusan::where([
                        ['detail_aset_id', '=', $request->detail_aset_id],
                        ['aset_penghapusan_id', '=', $request->aset_penghapusan_id]
                    ])->count();
                    if ($cek != 0) {
                        $fail('Kode detail aset sudah tersedia di list.');
                    }
                },
            ],
            'kondisi' => 'required',
        ]);

        Detail_aset_penghapusan::create($validated);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detail_aset_penghapusan  $detail_aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_aset_penghapusan $detail_aset_penghapusan)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail_aset_penghapusan  $detail_aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_aset_penghapusan $detail_aset_penghapusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detail_aset_penghapusan  $detail_aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail_aset_penghapusan $detail_aset_penghapusan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_aset_penghapusan  $detail_aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_aset_penghapusan $detail_aset_penghapusan)
    {
        Detail_aset_penghapusan::destroy($detail_aset_penghapusan->id);
        return redirect()->back();
    }
}
