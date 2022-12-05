<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Saloka',
            'alamat' => "Jl. Lopait",
            'telepon' => '07654776',
            'tipe_nota' => 1,
            'diskon' => 5,
            'path_logo' => '',
            'path_kartu_member' => ''
        ]);
    }
}
