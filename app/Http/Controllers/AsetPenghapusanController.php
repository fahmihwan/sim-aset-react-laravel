<?php

namespace App\Http\Controllers;

use App\Models\Aset_penghapusan;
use App\Models\Detail_aset;
use App\Models\Detail_aset_penghapusan;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AsetPenghapusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aset_penghapusan = Aset_penghapusan::paginate(5);

        return Inertia::render('Aset_penghapusan/Index', [
            'aset_penghapusan' => $aset_penghapusan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode = '#HP' .  Carbon::now()->format('dmyHis');
        return Inertia::render('Aset_penghapusan/Create', [
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
            'tanggal_penghapusan' => 'required',
        ]);

        Aset_penghapusan::create([
            'kode_penghapusan' => $request->kode,
            'user_id' => auth()->user()->id,
            'keterangan' => $request->keterangan,
            'tanggal_penghapusan' => $request->tanggal_penghapusan,
            'verifikasi' => false
        ]);

        return redirect('/aset_penghapusan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aset_penghapusan  $aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function show(Aset_penghapusan $aset_penghapusan)
    {

        $detail_aset_penghapusan = Detail_aset_penghapusan::with([
            'detail_aset:id,kode_detail_aset,aset_id,ruangan_id',
            'detail_aset.aset:id,nama',
            'detail_aset.ruangan:id,ruangan',
        ])
            ->where('aset_penghapusan_id', $aset_penghapusan->id)
            ->latest()
            ->get();

        return Inertia::render('Aset_penghapusan/Show', [
            'aset_penghapusan' => $aset_penghapusan,
            'ruangans' => Ruangan::latest()->get(),
            'detail_aset_penghapusans' => $detail_aset_penghapusan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aset_penghapusan  $aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset_penghapusan $aset_penghapusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aset_penghapusan  $aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset_penghapusan $aset_penghapusan)
    {

        try {
            DB::beginTransaction();

            // update verify
            Aset_penghapusan::where('id', $aset_penghapusan->id)->update([
                'verifikasi' => $request->verifikasi
            ]);

            // list detail aset_mutasi
            $detail_aset_penghapusan = Detail_aset_penghapusan::select([
                'detail_aset_id',
            ])
                ->where('aset_penghapusan_id', $aset_penghapusan->id)
                ->get();


            foreach ($detail_aset_penghapusan as $d) {
                // update detail aset

                if ($request->verifikasi) {
                    Detail_aset::destroy($d->detail_aset_id);
                } else {
                    Detail_aset::where('id', $d->detail_aset_id)->restore();
                }
            }


            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;\
            DB::rollBack();
            dd($th->getMessage());
        }



        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aset_penghapusan  $aset_penghapusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset_penghapusan $aset_penghapusan)
    {
        Aset_penghapusan::destroy($aset_penghapusan->id);
        return redirect()->back();
    }
}
