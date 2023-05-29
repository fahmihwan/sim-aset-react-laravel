<?php

namespace App\Http\Controllers;

use App\Models\Detail_aset;
use App\Models\Detail_aset_penghapusan;
use Illuminate\Http\Request;

class DetailAsetPenghapusanController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detail_asettt = Detail_aset::where('id', $request->detail_aset_id)->first();
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
        ]);
        $validated['kondisi'] = $detail_asettt->kondisi;

        Detail_aset_penghapusan::create($validated);
        return redirect()->back();
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
