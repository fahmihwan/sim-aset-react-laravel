<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Aset_mutasi;
use App\Models\Aset_penghapusan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function laporan_masuk()
    {
        $data = Aset_masuk::with([
            'detail_asets',
            'detail_asets.ruangan:id,ruangan',
            'detail_asets.aset:id,nama'
        ])->paginate(5);

        return Inertia::render('Laporan/LaporanMasuk', [
            'data' => $data
        ]);
    }
    public function laporan_mutasi()
    {
        $data = Aset_mutasi::with([
            'detail_aset_mutasis',
            'detail_aset_mutasis.detail_aset:id,kode_detail_aset,aset_id',
            'detail_aset_mutasis.detail_aset.aset:id,nama',
            'detail_aset_mutasis.asal_ruangan:id,ruangan',
            'detail_aset_mutasis.tujuan_ruangan:id,ruangan'
        ])->paginate(5);
        return Inertia::render('Laporan/LaporanMutasi', [
            'data' => $data
        ]);
    }
    public function laporan_dihapuskan()
    {
        $data =  Aset_penghapusan::with([
            'detail_aset_penghapusans',
            'detail_aset_penghapusans.detail_aset.ruangan:id,ruangan',
            'detail_aset_penghapusans.detail_aset.aset:id,nama'
        ])->paginate(5);

        return Inertia::render('Laporan/LaporanPenghapusan', [
            'data' => $data
        ]);
    }
}
