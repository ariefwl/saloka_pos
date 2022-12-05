<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserLevel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('level')->insert(
            [
                'nama_level' => 'Administrator',
            ],
            [
                'nama_level' => 'Supervisor'
            ],
            [
                'nama_level' => 'Kasir'
            ],
            [
                'nama_level' => 'Gudang'
            ]
        );
    }
}
