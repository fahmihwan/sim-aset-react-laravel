<?php

namespace App\Http\Controllers;

use App\Models\Detail_aset;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InformasiAsetController extends Controller
{
    public function index()
    {
        $detail_asets = Detail_aset::with([
            'aset:id,nama,kategori_id',
            'aset.kategori:id,kategori',
            'ruangan',
            'aset_masuk:id,tanggal_masuk'
        ])->paginate(5);

        return Inertia::render('Informasi_aset/Index', [
            'detail_asets' => $detail_asets
        ]);
    }
    public function list_kelas()
    {
        return Inertia::render('Informasi_aset/List_kelas', [
            'ruangans' => Ruangan::paginate(5)
        ]);
    }

    public function aset_dihapuskan()
    {
        $detail_asets = Detail_aset::onlyTrashed()->with([
            'aset:id,nama,kategori_id',
            'aset.kategori:id,kategori',
            'ruangan',
            'aset_masuk:id,tanggal_masuk'
        ])->paginate(5);



        return Inertia::render('Informasi_aset/Aset_dihapuskan', [
            'detail_asets' => $detail_asets
        ]);
    }

    public function show($id)
    {
        return Inertia::render('Informasi_aset/Show');
    }
}
