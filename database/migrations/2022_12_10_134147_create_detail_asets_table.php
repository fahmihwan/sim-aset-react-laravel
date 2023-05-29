<?php

use App\Models\Aset;
use App\Models\Aset_masuk;
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
        Schema::create('detail_asets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_detail_aset');
            $table->foreignIdFor(Aset::class);
            $table->foreignIdFor(Ruangan::class);
            $table->foreignIdFor(Aset_masuk::class);
            $table->enum('kondisi', ['bagus', 'hilang', 'rusak', 'layak']);
            $table->softDeletes();
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
        Schema::dropIfExists('detail_asets');
    }
};
