<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email' => 'ceo@gmail.com',
                'password' => Hash::make('ceo'),
                'jabatan_id' => 1,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 1,
                'nip'         => '01',
                'nama'        => 'Sabang Digital Indonesia',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'       => 'pm@gmail.com',
                'password'    => Hash::make('pm'),
                'jabatan_id'  => 2,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 2,
                'nip'         => '02',
                'nama'        => 'Sabang Digital Indonesia',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'karyawan@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '03',
                'nama'        => 'Sabang Digital Indonesia',
            ]);
        });
    }
}
