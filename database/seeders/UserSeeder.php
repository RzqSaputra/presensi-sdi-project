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
                'nip'         => '2008030001',
                'nama'        => 'Lukman Hakim Prasetyo',
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
                'nip'         => '2009040001',
                'nama'        => 'Auliaur Rasyid',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'rizky@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '2108160001',
                'nama'        => 'Rizky Prasetya',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'fauzan@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '221018001',
                'nama'        => 'Muhammad Fauzan Reza Pahlevi',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'adit@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '221116002',
                'nama'        => 'Risky Putra Aditya',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'haris@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '221219002',
                'nama'        => 'Haris Wijayanto',
            ]);
        });

        DB::transaction(function () {
            $user_id = DB::table('users')->insertGetId([
                'email'      => 'ridho@gmail.com',
                'password'   => Hash::make('karyawan'),
                'jabatan_id' => 3,
            ]);

            DB::table('karyawans')->insert([
                'user_id'     => $user_id,
                'jabatan_id'  => 3,
                'nip'         => '221219001',
                'nama'        => 'Ridho ',
            ]);
        });
    }
}
