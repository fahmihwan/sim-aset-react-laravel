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
        Schema::create('aset_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_masuk');
            $table->foreignIdFor(User::class);
            $table->text('keterangan');
            $table->boolean('verifikasi');
            $table->date('tanggal_masuk');
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
        Schema::dropIfExists('aset_masuks');
    }
};
