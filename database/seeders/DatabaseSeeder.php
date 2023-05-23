<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'hak_akses' => 'kepala_sekolah',
            'password' => Hash::make('qweqwe123')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'sarpras',
            'email' => 'sarpras@gmail.com',
            'hak_akses' => 'sarpras',
            'password' => Hash::make('qweqwe123')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'sekertaris',
            'email' => 'sekertaris@gmail.com',
            'hak_akses' => 'sekertaris',
            'password' => Hash::make('qweqwe123')
        ]);

        // hapus aja
        // \App\Models\Kategori::create([
        //     'kategori' => 'mebel'
        // ]);

        // \App\Models\Aset::create([
        //     'nama' => 'meja',
        //     'kategori_id' => 1
        // ]);
        // \App\Models\Ruangan::create([
        //     'ruangan' => 'kelas 7A',
        // ]);
        // \App\Models\Ruangan::create([
        //     'ruangan' => 'kelas 7B',
        // ]);
        // \App\Models\Ruangan::create([
        //     'ruangan' => 'Gudang',
        // ]);
        // \App\Models\Gudang::create([
        //     'ruangan_id' => 3,
        // ]);
        // \App\Models\Aset_masuk::create([
        //     'kode_masuk' => '#AST230523051513',
        //     'user_id' => 2,
        //     'keterangan' => 'data dari pemkab',
        //     'penerima' => 'budi gunawan',
        //     'verifikasi' => false,
        //     'tanggal_masuk' => date('Y-m-d'),
        // ]);



        // $table->string('name');
        // $table->string('email')->unique();
        // $table->enum('hak_akses', ['kepala_sekolah', 'sarpras', 'sekertaris']);
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
    }
}
