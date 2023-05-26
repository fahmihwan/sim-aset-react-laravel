<?php

use App\Models\Aset_penghapusan;
use App\Models\Detail_aset;
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
        Schema::create('detail_aset_penghapusans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Aset_penghapusan::class);
            $table->foreignIdFor(Detail_aset::class);
            $table->enum('kondisi', ['hilang', 'rusak']);
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
        Schema::dropIfExists('detail_aset_penghapusans');
    }
};
