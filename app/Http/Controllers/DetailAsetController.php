<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Detail_aset;
use App\Models\Gudang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetailAsetController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aset_id' => 'required',
            'ruangan_id' => 'required',
            'aset_masuk_id' => 'required',
            'jumlah' => 'required',
        ]);

        function generate_kode($kode, $validated)
        {

            $data = [];
            for ($i = 1; $i <= $validated['jumlah']; $i++) {
                $data[] = [
                    'kode_detail_aset' => 'MD' . date("Ymd") . sprintf("%03d", $kode++),
                    'aset_id' => $validated['aset_id'],
                    'ruangan_id' => $validated['ruangan_id'],
                    'aset_masuk_id' => $validated['aset_masuk_id'],
                ];
            }
            return $data;
        }


        // cek jika tanggal sekarang != kode
        // increment mulai dari 0
        // jika sama 
        // increment dari yg sebelumnya
        // cek gudang 
        $gudang = Gudang::select('ruangan_id')->first();

        if (Detail_aset::where('ruangan_id', $gudang->ruangan_id)->exists()) { //jika ada
            $last_detail_aset_id =  Detail_aset::select(["kode_detail_aset", "created_at"])
                ->where('ruangan_id', $gudang->ruangan_id)
                ->orderBy('kode_detail_aset', 'DESC')
                ->limit(1)
                ->first();
            $get_date_from_kode = substr($last_detail_aset_id->kode_detail_aset, 2, 8);
            if (date("Ymd") != $get_date_from_kode) {
                $data = generate_kode(001, $validated);
            } else {
                $startIncrement = (int)substr($last_detail_aset_id->kode_detail_aset, 10);
                $data = generate_kode($startIncrement + 1, $validated);
            }
        } else { //jika tidak ada

            $data = generate_kode(001, $validated);
        }


        foreach ($data as $d) {
            Detail_aset::create([
                'kode_detail_aset' => $d['kode_detail_aset'],
                'aset_id' => $d['aset_id'],
                'ruangan_id' => $d['ruangan_id'],
                'aset_masuk_id' => $d['aset_masuk_id'],
                'kondisi' => 'bagus'
            ]);
        }

        return redirect()->back();

        return redirect()->back()->with([
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
        if (Aset_masuk::where('id', $detail_aset->aset_masuk_id)->first()->verifikasi == 0) {
            Detail_aset::where('id', $detail_aset->id)->forceDelete();
        } else {
            return redirect()->back()->with('message', 'data yang sudah terverifikasi tidak dapat dihapus');
        }
    }
}
