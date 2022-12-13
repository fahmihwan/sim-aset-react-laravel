<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_aset extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
