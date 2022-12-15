<?php

use App\Models\User;
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
        Schema::create('aset_penghapusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penghapusan');
            $table->foreignIdFor(User::class);
            $table->string('keterangan');
            $table->date('tanggal_penghapusan');
            $table->boolean('verifikasi');
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
        Schema::dropIfExists('aset_penghapusans');
    }
};
