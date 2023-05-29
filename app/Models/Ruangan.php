<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime:l, d-m-Y',
    ];
    public function detail_aset_mutasis()
    {
        return $this->hasMany(Detail_aset_mutasi::class);
    }
}
