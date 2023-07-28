<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jabatans')->insert(
            [
                'jabatan' => 'CEO'
            ]
        );
        DB::table('jabatans')->insert(
            [
                'jabatan' => 'Project Manager'
            ]
        );
        DB::table('jabatans')->insert(
            [
                'jabatan' => 'Karyawan'
            ]
        );
    }
}
