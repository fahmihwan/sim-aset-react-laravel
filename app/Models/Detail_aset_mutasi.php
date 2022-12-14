<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Detail_aset_mutasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function detail_aset()
    {
        return $this->belongsTo(Detail_aset::class)->withTrashed();
    }

    public function asal_ruangan()
    {
        return $this->belongsTo(Ruangan::class)->withTrashed();
    }

    public function tujuan_ruangan()
    {
        return $this->belongsTo(Ruangan::class)->withTrashed();
    }
}
