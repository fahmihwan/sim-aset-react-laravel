<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Aset_mutasi;
use App\Models\Aset_penghapusan;
use Illuminate\Http\Request;
use Inertia\Inertia;


use Barryvdh\DomPDF\Facade\Pdf;
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

    public function export_pdf_masuk(Request $request)
    {

        $start_date = '2022-12-14';
        $end_date = '2022-12-15';

        $data = Aset_masuk::with([
            'detail_asets',
            'detail_asets.ruangan:id,ruangan',
            'detail_asets.aset:id,nama'
        ])
            // ->whereBetween('aset_masuks.tanggal_masuk', [request('start_date'), request('end_date')])
            ->whereBetween('aset_masuks.tanggal_masuk', [$start_date, $end_date])
            // ->whereBetween('aset_masuks.tanggal_masuk', [$request->start_date, $request->end_date])
            ->get();


        // return view('pdf.laporan_masuk', [
        //     'data' => $data,
        //     'start_date' => $start_date,
        //     'end_date' => $end_date,
        // ]);
        // $pdf = Pdf::loadView('pdf.laporan_masuk', [
        //     'data' => $data,
        //     'start_date' => $start_date,
        //     'end_date' => $end_date,
        // ]);
        $pdf = Pdf::loadView('pdf.laporan_masuk');
        return $pdf->download('invoice.pdf');


        // $pdf = PDF::loadview('PDF.laporan_masuk', ['data' => $data]);
        //     // return $pdf->download('laporan-pegawai-pdf');
        // }
    }
}
