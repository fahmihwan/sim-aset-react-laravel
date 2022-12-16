<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset_masuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_masuk' => 'datetime:l, d-m-Y',
    ];

    public function detail_asets()
    {
        return $this->hasMany(Detail_aset::class)->withTrashed();
    }
}
