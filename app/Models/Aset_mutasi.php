<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset_mutasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detail_aset_mutasis()
    {
        return $this->hasMany(Detail_aset_mutasi::class);
    }
}
