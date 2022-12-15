<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset_penghapusan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function detail_aset_penghapusans()
    {
        return $this->hasMany(Detail_aset_penghapusan::class);
    }
}
