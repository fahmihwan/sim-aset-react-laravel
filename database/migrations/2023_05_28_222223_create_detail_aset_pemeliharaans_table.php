<?php

use App\Models\Aset_pemeliharaan;
use App\Models\Detail_aset;
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
        Schema::create('detail_aset_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Aset_pemeliharaan::class);
            $table->foreignIdFor(Detail_aset::class);
            $table->enum('kondisi', ['bagus', 'hilang', 'rusak', 'layak']);
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
        Schema::dropIfExists('detail_aset_pemeliharaans');
    }
};
