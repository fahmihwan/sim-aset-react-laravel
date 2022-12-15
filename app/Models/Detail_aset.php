<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_aset extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'updated_at' => 'datetime:l, d-m-Y',
    ];


    public function aset()
    {
        return $this->belongsTo(Aset::class)->withTrashed();
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class)->withTrashed();
    }

    public function aset_masuk()
    {
        return $this->belongsTo(Aset_masuk::class);
    }
}
