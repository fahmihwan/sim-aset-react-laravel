<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Aset_mutasi;
use App\Models\Aset_pemeliharaan;
use App\Models\Aset_penghapusan;
use Illuminate\Http\Request;
use Inertia\Inertia;



use Illuminate\Support\Facades\App;

use function Termwind\render;

class LaporanController extends Controller
{
    public function laporan_masuk()
    {

        $data = Aset_masuk::with([
            'detail_asets',
            'detail_asets.ruangan:id,ruangan',
            'detail_asets.aset:id,nama'
        ])->paginate(5);


        if (request('start_date')) {
            $data = Aset_masuk::with([
                'detail_asets',
                'detail_asets.ruangan:id,ruangan',
                'detail_asets.aset:id,nama'
            ])
                ->whereBetween('aset_masuks.tanggal_masuk', [request('start_date'), request('end_date')])
                ->paginate(5);
        }

        return Inertia::render('Laporan/LaporanMasuk', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
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

        if (request('start_date')) {
            $data = Aset_mutasi::with([
                'detail_aset_mutasis',
                'detail_aset_mutasis.detail_aset:id,kode_detail_aset,aset_id',
                'detail_aset_mutasis.detail_aset.aset:id,nama',
                'detail_aset_mutasis.asal_ruangan:id,ruangan',
                'detail_aset_mutasis.tujuan_ruangan:id,ruangan'
            ])
                ->whereBetween('aset_mutasis.tanggal_mutasi', [request('start_date'), request('end_date')])
                ->paginate(5);
        }

        return Inertia::render('Laporan/LaporanMutasi', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ]);
    }
    public function laporan_dihapuskan()
    {
        $data =  Aset_penghapusan::with([
            'detail_aset_penghapusans',
            'detail_aset_penghapusans.detail_aset.ruangan:id,ruangan',
            'detail_aset_penghapusans.detail_aset.aset:id,nama'
        ])->paginate(5);

        if (request('start_date')) {
            $data =  Aset_penghapusan::with([
                'detail_aset_penghapusans',
                'detail_aset_penghapusans.detail_aset.ruangan:id,ruangan',
                'detail_aset_penghapusans.detail_aset.aset:id,nama'
            ])
                ->whereBetween('aset_penghapusans.tanggal_penghapusan', [request('start_date'), request('end_date')])
                ->paginate(5);
        }

        return Inertia::render('Laporan/LaporanPenghapusan', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ]);
    }
    public function laporan_pemeliharaan()
    {
        $data =  Aset_pemeliharaan::with([
            'detail_aset_pemeliharaans',
            'detail_aset_pemeliharaans.detail_aset.ruangan:id,ruangan',
            'detail_aset_pemeliharaans.detail_aset.aset:id,nama'
        ])->paginate(5);


        if (request('start_date')) {
            $data =  Aset_pemeliharaan::with([
                'detail_aset_pemeliharaans',
                'detail_aset_pemeliharaans.detail_aset.ruangan:id,ruangan',
                'detail_aset_pemeliharaans.detail_aset.aset:id,nama'
            ])
                ->whereBetween('aset_pemeliharaans.tanggal_pemeliharaan', [request('start_date'), request('end_date')])
                ->paginate(5);
        }

        // return view('pdf.laporan_pemeliharaan', [
        //     'data' => $data,
        //     'start_date' => request('start_date'),
        //     'end_date' => request('end_date')
        // ]);
        return Inertia::render('Laporan/LaporanPemeliharaan', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ]);
    }
}
