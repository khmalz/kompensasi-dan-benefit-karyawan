<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Tunjangan;
use Illuminate\Database\Seeder;

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

        // ID 1
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        // ID 2
        User::create([
            'name' => 'AH',
            'email' => 'ah@gmail.com',
            'password' => bcrypt('passwordah')
        ]);

        // ID 3
        User::create([
            'name' => 'RM',
            'email' => 'rm@gmail.com',
            'password' => bcrypt('passwordrm')
        ]);

        Karyawan::create([
            'nik' => 'RTS20210711',
            'user_id' => 2,
            'nama' => 'AH',
            'status' => 'Permanen',
            'lokasi' => 'Jakarta',
            'tanggal_masuk' => '2021-06-01',
        ]);

        Karyawan::create([
            'nik' => 'RTS20210712',
            'user_id' => 3,
            'nama' => 'RM',
            'status' => 'Permanen',
            'lokasi' => 'Jakarta',
            'tanggal_masuk' => '2018-02-24',
        ]);

        Tunjangan::create([
            'kode' => '69P1CZGV0Q',
            'karyawan_nik' => 'RTS20210711',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 150000,
            'status' => 'belum',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-10-08" . now()->format('H:i:s'),
            'updated_at' => "2022-10-08" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'X9AJH4OWVM',
            'karyawan_nik' => 'RTS20210711',
            'jenis_tunjangan' => 'tunjangan_pernikahan',
            'besar_tunjangan' => 2000000,
            'status' => 'belum',
            'pesan' => 'Menikah',
            'bukti' => 'bukti/20221005092955.jpg',
            'created_at' => "2022-10-06" . now()->format('H:i:s'),
            'updated_at' => "2022-10-06" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'J5N1ZF6BVE',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 100000,
            'status' => 'belum',
            'pesan' => 'Untuk Berobat',
            'bukti' => 'bukti/20221003030840.jpg'
        ]);

        Tunjangan::create([
            'kode' => 'RS2QPZLJ3G',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 1000000,
            'status' => 'belum',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-10-07" . now()->format('H:i:s'),
            'updated_at' => "2022-10-07" . now()->format('H:i:s'),
        ]);
    }
}
