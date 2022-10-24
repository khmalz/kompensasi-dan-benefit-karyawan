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

        // ID 4
        User::create([
            'name' => 'DII',
            'email' => 'dii@gmail.com',
            'password' => bcrypt('passworddii')
        ]);

        // ID 5
        User::create([
            'name' => 'NS',
            'email' => 'ns@gmail.com',
            'password' => bcrypt('passwordns')
        ]);

        // ID 6
        User::create([
            'name' => 'IPC',
            'email' => 'ipc@gmail.com',
            'password' => bcrypt('passwordipc')
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

        Karyawan::create([
            'nik' => 'RTS20210701',
            'user_id' => 4,
            'nama' => 'DII',
            'status' => 'Permanen',
            'lokasi' => 'Jakarta',
            'tanggal_masuk' => '2018-02-24',
        ]);

        Karyawan::create([
            'nik' => 'RTS20210710',
            'user_id' => 5,
            'nama' => 'NS',
            'status' => 'Permanen',
            'lokasi' => 'Jakarta',
            'tanggal_masuk' => '2018-02-24',
        ]);

        Karyawan::create([
            'nik' => 'RTS20210708',
            'user_id' => 6,
            'nama' => 'IPC',
            'status' => 'Permanen',
            'lokasi' => 'Jakarta',
            'tanggal_masuk' => '2018-02-24',
        ]);

        Tunjangan::create([
            'kode' => '69P1CZGV0Q',
            'karyawan_nik' => 'RTS20210711',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 150000,
            'status' => 'sudah',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-10-19" . now()->format('H:i:s'),
            'updated_at' => "2022-10-19" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => '1GK0RVWX9I',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 170000,
            'status' => 'sudah',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-10-11" . now()->format('H:i:s'),
            'updated_at' => "2022-10-11" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'B4I9ROD2A0',
            'karyawan_nik' => 'RTS20210710',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 100000,
            'status' => 'sudah',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-09-28" . now()->format('H:i:s'),
            'updated_at' => "2022-09-28" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'RS2QPZLJ3G',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 2000000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-10-04" . now()->format('H:i:s'),
            'updated_at' => "2022-10-04" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'L6RQEAFH0M',
            'karyawan_nik' => 'RTS20210711',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 1900000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-10-01" . now()->format('H:i:s'),
            'updated_at' => "2022-10-01" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'NDRU75HTVW',
            'karyawan_nik' => 'RTS20210708',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 2300000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-09-15" . now()->format('H:i:s'),
            'updated_at' => "2022-09-15" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'X68FDGUQVY',
            'karyawan_nik' => 'RTS20210710',
            'jenis_tunjangan' => 'tunjangan_pernikahan',
            'besar_tunjangan' => 1000000,
            'status' => 'sudah',
            'pesan' => 'Untuk Menikah',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-10-07" . now()->format('H:i:s'),
            'updated_at' => "2022-10-07" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'WMZU6GKQ0R',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 170000,
            'status' => 'sudah',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-09-25" . now()->format('H:i:s'),
            'updated_at' => "2022-09-25" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'ISB9QFH7GP',
            'karyawan_nik' => 'RTS20210710',
            'jenis_tunjangan' => 'tunjangan_kesehatan',
            'besar_tunjangan' => 100000,
            'status' => 'sudah',
            'pesan' => 'Untuk Mengobati Flu',
            'bukti' => 'bukti/20221003031157.jpeg',
            'created_at' => "2022-10-13" . now()->format('H:i:s'),
            'updated_at' => "2022-10-13" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => '7NPTVOSRWJ',
            'karyawan_nik' => 'RTS20210712',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 2000000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-09-17" . now()->format('H:i:s'),
            'updated_at' => "2022-09-17" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'L5NTMRS34E',
            'karyawan_nik' => 'RTS20210701',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 1900000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-10-22" . now()->format('H:i:s'),
            'updated_at' => "2022-10-22" . now()->format('H:i:s'),
        ]);

        Tunjangan::create([
            'kode' => 'W2OQGEJNBX',
            'karyawan_nik' => 'RTS20210708',
            'jenis_tunjangan' => 'tunjangan_bencana',
            'besar_tunjangan' => 2300000,
            'status' => 'sudah',
            'pesan' => 'Untuk Memperbaiki Laptop',
            'bukti' => 'bukti/20221003031027.jpg',
            'created_at' => "2022-10-03" . now()->format('H:i:s'),
            'updated_at' => "2022-10-03" . now()->format('H:i:s'),
        ]);
    }
}
