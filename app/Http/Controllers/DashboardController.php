<?php

namespace App\Http\Controllers;

use App\Models\Aset_masuk;
use App\Models\Detail_aset;
use App\Models\Detail_aset_mutasi;
use App\Models\Detail_aset_penghapusan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $aset_masuk = Detail_aset::withTrashed()->join('aset_masuks', 'detail_asets.aset_masuk_id', '=', 'aset_masuks.id')
            ->select(DB::raw('count(detail_asets.created_at) as total, month(aset_masuks.tanggal_masuk) as bulan'))
            ->groupBy(DB::raw('month(aset_masuks.tanggal_masuk)'))
            ->whereYear('aset_masuks.tanggal_masuk', Carbon::now()->format('Y'))
            ->get();

        $detail_aset_mutasi = Detail_aset_mutasi::join('aset_mutasis', 'detail_aset_mutasis.aset_mutasi_id', '=', 'aset_mutasis.id')
            ->join('detail_asets', 'detail_aset_mutasis.detail_aset_id', '=', 'detail_asets.id')
            ->select(DB::raw('count(aset_mutasis.tanggal_mutasi) as total, month(aset_mutasis.tanggal_mutasi) as bulan'))
            ->groupBy(DB::raw('month(aset_mutasis.tanggal_mutasi)'))
            ->whereYear('aset_mutasis.tanggal_mutasi', Carbon::now()->format('Y'))
            ->get();

        $detail_aset_penghapusan = Detail_aset_penghapusan::join('aset_penghapusans', 'detail_aset_penghapusans.aset_penghapusan_id', '=', 'aset_penghapusans.id')
            ->join('detail_asets', 'detail_aset_penghapusans.detail_aset_id', '=', 'detail_asets.id')
            ->select(DB::raw('count(aset_penghapusans.tanggal_penghapusan) as total, month(aset_penghapusans.tanggal_penghapusan) as bulan'))
            ->groupBy(DB::raw('month(aset_penghapusans.tanggal_penghapusan)'))
            ->whereYear('aset_penghapusans.tanggal_penghapusan', Carbon::now()->format('Y'))
            ->get();

        $masuk = Detail_aset::whereYear('created_at', Carbon::now()->format('Y'))->count();
        $mutasi =  Detail_aset_mutasi::whereYear('created_at', Carbon::now()->format('Y'))->count();
        $penghapusan = Detail_aset_penghapusan::whereYear('created_at', Carbon::now()->format('Y'))->count();

        return Inertia::render('Dashboard', [
            'aset_masuk' => $aset_masuk,
            'detail_aset_mutasi' => $detail_aset_mutasi,
            'detail_aset_penghapusan' => $detail_aset_penghapusan,
            'masuk' => $masuk,
            'mutasi' => $mutasi,
            'penghapusan' => $penghapusan
        ]);
    }
}
