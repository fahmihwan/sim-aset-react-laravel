<?php

use App\Models\Aset_mutasi;
use App\Models\Detail_aset;
use App\Models\Ruangan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_aset_mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Aset_mutasi::class);
            $table->foreignIdFor(Detail_aset::class);
            $table->foreignIdFor(Ruangan::class, 'asal_ruangan_id');
            $table->foreignIdFor(Ruangan::class, 'tujuan_ruangan_id');
            $table->enum('kondisi', ['bagus', 'layak', 'buruk']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_aset_mutasis');
    }
};
