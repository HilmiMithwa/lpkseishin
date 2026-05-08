<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Contoh akun hilmi
        DB::table('enrollment_list')->insert(
            [
                'id_user' => 6,
                'id_mapel' => 2
            ]
        );

        //Contoh akun Yussar
        DB::table('enrollment_list')->insert([
            [
                'id_user' => 8,
                'id_mapel' => 2
            ],
            [
                'id_user' => 8,
                'id_mapel' => 4
            ]
        ]);

    }
}
