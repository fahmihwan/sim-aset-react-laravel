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
        Schema::create('aset_mutasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mutasi');
            $table->foreignIdFor(User::class);
            $table->boolean('verifikasi');
            $table->date('tanggal_mutasi');
            $table->string('keterangan');
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
        Schema::dropIfExists('aset_mutasis');
    }
};
