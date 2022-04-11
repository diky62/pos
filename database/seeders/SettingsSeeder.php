<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('settings')->insert([
            'id' => 1,
            'nama_perusahaan' => 'FITRA Autotrans',
            'alamat' => 'Jl. Sawahkembang Desa Belawa',
            'telepon' => '085123456789',
            'tipe_nota' => 1, // kecil
            'path_logo' => '/img/logo.png',
        ]);
    }
}
