<?php

namespace App\Http\Controllers;

use App\Models\Aset_pemeliharaan;
use App\Models\Aset_penghapusan;
use App\Models\Detail_aset;
use App\Models\Detail_aset_mutasi;
use App\Models\Detail_aset_pemeliharaan;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PemeliharaanController extends Controller
{
    public function index()
    {
        return Inertia::render('Aset_pemeliharaan/Index', [
            'aset_pemeliharaan' =>  Aset_pemeliharaan::latest()->paginate(5)
        ]);
    }
    public function create()
    {

        $kode = '#PM' .  Carbon::now()->format('dmyHis');
        return Inertia::render('Aset_pemeliharaan/Create', [
            'kode' => $kode,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'keterangan' => 'required',
            'tanggal_pemeliharaan' => 'required',
        ]);

        Aset_pemeliharaan::create([
            'kode_pemeliharaan' => $request->kode,
            'user_id' => auth()->user()->id,
            'keterangan' => $request->keterangan,
            'tanggal_pemeliharaan' => $request->tanggal_pemeliharaan,
            'verifikasi' => false
        ]);
        return redirect('/aset_pemeliharaan');
    }

    public function destroy($id)
    {
        Aset_pemeliharaan::destroy($id);
        return redirect()->back();
    }
    public function show($id)
    {
        $detail_aset_pemeliharaans = Detail_aset_pemeliharaan::with([
            'detail_aset:id,kode_detail_aset,aset_id,ruangan_id',
            'detail_aset.aset:id,nama',
            'detail_aset.ruangan:id,ruangan',
        ])->where('aset_pemeliharaan_id', $id)
            ->latest()
            ->get();


        return Inertia::render('Aset_pemeliharaan/Show', [
            'aset_pemeliharaan' => Aset_pemeliharaan::where('id', $id)->first(),
            'ruangans' => Ruangan::latest()->get(),
            'detail_aset_pemeliharaans' => $detail_aset_pemeliharaans
        ]);
    }

    public function store_detail_pemeliharaan(Request $request)
    {
        $validated = $request->validate([
            'aset_pemeliharaan_id' => 'required',
            'detail_aset_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $cek = Detail_aset_pemeliharaan::where([
                        ['detail_aset_id', '=', $request->detail_aset_id],
                        ['aset_pemeliharaan_id', '=', $request->aset_pemeliharaan_id]
                    ])->count();
                    if ($cek != 0) {
                        $fail('Kode detail aset sudah tersedia di list.');
                    }
                },
            ],
            'kondisi' => 'required',
        ]);


        Detail_aset_pemeliharaan::create($validated);
        return redirect()->back();
    }

    public function destroy_detail_pemeliharaan($id)
    {
        $aset_pemeliharaan_id = Detail_aset_pemeliharaan::where('id', $id)->first()->aset_pemeliharaan_id;
        if (Aset_pemeliharaan::where('id', $aset_pemeliharaan_id)->first()->verifikasi == 0) {
            Detail_aset_pemeliharaan::destroy($id);
        } else {
            return redirect()->back()->with('message', 'data yang sudah terverifikasi tidak dapat dihapus');
        }
    }

    public function update(Request $request, $id)
    {


        try {
            DB::beginTransaction();

            // update verify
            Aset_pemeliharaan::where('id', $id)->update([
                'verifikasi' => $request->verifikasi
            ]);

            // list detail aset pemeliharaan
            $detail_aset_pemeliharaans = Detail_aset_pemeliharaan::where('aset_pemeliharaan_id', $id)
                ->get();


            // detail aset
            foreach ($detail_aset_pemeliharaans as $d) {
                // update detail aset
                $arr[] = $d;
                if ($request->verifikasi) {
                    Detail_aset_mutasi::where('detail_aset_id', $d->detail_aset_id)->update([
                        'kondisi' => $d->kondisi
                    ]);
                    Detail_aset::where('id', $d->detail_aset_id)->update([
                        'kondisi' => $d->kondisi
                    ]);
                } else {
                    Detail_aset_mutasi::where('detail_aset_id', $d->detail_aset_id)->update([
                        'kondisi' => 'bagus'
                    ]);
                    Detail_aset::where('id', $d->detail_aset_id)->update([
                        'kondisi' => 'bagus'
                    ]);
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
}
