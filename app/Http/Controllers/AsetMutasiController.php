<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Aset_mutasi;
use App\Models\Detail_aset;
use App\Models\Detail_aset_mutasi;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'aset_mutasi' => Aset_mutasi::latest()->paginate(5)
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
        ]);
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
        // update verfikasi
        Aset_mutasi::where('id', $aset_mutasi->id)->update([
            'verifikasi' => $request->verifikasi
        ]);

        try {
            DB::beginTransaction();
            // update verify
            Aset_mutasi::where('id', $aset_mutasi->id)->update([
                'verifikasi' => $request->verifikasi
            ]);

            // list detail aset_mutasi
            $detail_asset_mutasi = Detail_aset_mutasi::select([
                'detail_aset_id',
                'asal_ruangan_id',
                'tujuan_ruangan_id',
                'kondisi'
            ])
                ->where('aset_mutasi_id', $aset_mutasi->id)
                ->get();



            foreach ($detail_asset_mutasi as $d) {
                // update detail aset
                if ($request->verifikasi) {
                    Detail_aset::where('id', $d->detail_aset_id)->update([
                        'ruangan_id' => $d->tujuan_ruangan_id,
                        'kondisi' => $d->kondisi,
                    ]);
                } else {
                    Detail_aset::where('id', $d->detail_aset_id)->update([
                        'ruangan_id' => $d->asal_ruangan_id,
                        'kondisi' => $d->kondisi,
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset_mutasi  $aset_mutasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset_mutasi $aset_mutasi)
    {
        Aset_mutasi::destroy($aset_mutasi->id);
        return redirect()->back();
    }

    function get_detail_aset($id)
    {
        return Detail_aset::with(['ruangan', 'aset'])->where('ruangan_id', $id)->get();
    }
    function get_detail_aset_for_penghapusan($id)
    {
        return Detail_aset::with(['ruangan', 'aset'])
            ->where('ruangan_id', $id)
            ->whereIn('kondisi', ['hilang', 'rusak'])
            ->get();
    }
}
