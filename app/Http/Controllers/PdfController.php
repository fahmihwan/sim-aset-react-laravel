<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Aset_mutasi;
use App\Models\Aset_pemeliharaan;
use App\Models\Aset_penghapusan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function export_pdf_masuk()
    {
        $data = Aset_masuk::with([
            'detail_asets',
            'detail_asets.ruangan:id,ruangan',
            'detail_asets.aset:id,nama'
        ])
            ->whereBetween('aset_masuks.tanggal_masuk', [request('start_date'), request('end_date')])
            ->get();

        if ($data->count() == 0) {
            return 0;
        }
        $pdf = Pdf::loadView('pdf.laporan_masuk', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function export_pdf_mutasi()
    {
        $data = Aset_mutasi::with([
            'detail_aset_mutasis',
            'detail_aset_mutasis.detail_aset:id,kode_detail_aset,aset_id',
            'detail_aset_mutasis.detail_aset.aset:id,nama',
            'detail_aset_mutasis.asal_ruangan:id,ruangan',
            'detail_aset_mutasis.tujuan_ruangan:id,ruangan'
        ])
            ->whereBetween('aset_mutasis.tanggal_mutasi', [request('start_date'), request('end_date')])
            ->get();

        if ($data->count() == 0) {
            return 0;
        }
        // return view('pdf.laporan_mutasi', [
        //     'data' => $data,
        //     'start_date' => request('start_date'),
        //     'end_date' => request('end_date'),
        // ]);

        $pdf = Pdf::loadView('pdf.laporan_mutasi', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function export_pdf_penghapusan()
    {
        $data = Aset_penghapusan::with([
            'detail_aset_penghapusans',
            'detail_aset_penghapusans.detail_aset.ruangan:id,ruangan',
            'detail_aset_penghapusans.detail_aset.aset:id,nama'
        ])
            ->whereBetween('aset_penghapusans.tanggal_penghapusan', [request('start_date'), request('end_date')])
            ->get();


        return $data;
        if ($data->count() == 0) {
            return 0;
        }
        // return view('pdf.laporan_penghapusan', [
        //     'data' => $data,
        //     'start_date' => request('start_date'),
        //     'end_date' => request('end_date'),
        // ]);

        // $pdf = Pdf::loadView('pdf.laporan_penghapusan', [
        //     'data' => $data,
        //     'start_date' => request('start_date'),
        //     'end_date' => request('end_date'),
        // ]);
        // return $pdf->download('laporan.pdf');
    }

    public function export_pdf_pemeliharaans()
    {
        $data =  Aset_pemeliharaan::with([
            'detail_aset_pemeliharaans',
            'detail_aset_pemeliharaans.detail_aset.ruangan:id,ruangan',
            'detail_aset_pemeliharaans.detail_aset.aset:id,nama'
        ])
            ->whereBetween('aset_pemeliharaans.tanggal_pemeliharaan', [request('start_date'), request('end_date')])
            ->paginate(5);


        $pdf = Pdf::loadView('pdf.laporan_pemeliharaan', [
            'data' => $data,
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function export_detail_masuk()
    {
        $data = Aset_masuk::with([
            'detail_asets',
            'detail_asets.ruangan:id,ruangan',
            'detail_asets.aset:id,nama'
        ])->where('aset_masuks.id', request('id'))->first();

        if ($data->count() == 0) {
            return 0;
        }

        $pdf = Pdf::loadView('pdf.masuk', [
            'data' => $data,
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function export_detail_mutasi()
    {
        $data = Aset_mutasi::with([
            'detail_aset_mutasis',
            'detail_aset_mutasis.detail_aset:id,kode_detail_aset,aset_id',
            'detail_aset_mutasis.detail_aset.aset:id,nama',
            'detail_aset_mutasis.asal_ruangan:id,ruangan',
            'detail_aset_mutasis.tujuan_ruangan:id,ruangan'
        ])
            ->where('aset_mutasis.id', request('id'))
            ->first();
        if ($data->count() == 0) {
            return 0;
        }
        $pdf = Pdf::loadView('pdf.mutasi', [
            'data' => $data,
        ]);
        return $pdf->download('laporan.pdf');
    }
    public function export_detail_penghapusan()
    {
        $data = Aset_penghapusan::with([
            'detail_aset_penghapusans',
            'detail_aset_penghapusans.detail_aset.ruangan:id,ruangan',
            'detail_aset_penghapusans.detail_aset.aset:id,nama'
        ])
            ->where('aset_penghapusans.id', request('id'))
            ->first();

        if ($data->count() == 0) {
            return 0;
        }
        $pdf = Pdf::loadView('pdf.penghapusan', [
            'data' => $data,
        ]);
        return $pdf->download('laporan.pdf');
    }
    public function export_detail_pemeliharaans()
    {
        $data =  Aset_pemeliharaan::with([
            'detail_aset_pemeliharaans',
            'detail_aset_pemeliharaans.detail_aset.ruangan:id,ruangan',
            'detail_aset_pemeliharaans.detail_aset.aset:id,nama'
        ])
            ->where('aset_pemeliharaans.id', request('id'))
            ->first();
        // return view('pdf.pemeliharaan', [
        //     'data' => $data
        // ]);
        if ($data->count() == 0) {
            return 0;
        }

        // return $data;
        // return view('pdf.pemeliharaan', [
        //     'data' => $data
        // ]);

        $pdf = Pdf::loadView('pdf.pemeliharaan', [
            'data' => $data,
        ]);
        return $pdf->download('laporan.pdf');
    }
}
