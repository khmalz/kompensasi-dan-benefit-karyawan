<?php

namespace App\Http\Controllers;

use App\Models\Tunjangan;

class RiwayatTunjanganController extends Controller
{
    public function index()
    {
        $tanggal = request()->tanggal;
        $jenis_tunjangan = request()->jenis;
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->where('created_at', 'like', "%$tanggal%")->where('jenis_tunjangan', 'like', "%$jenis_tunjangan%")->where('status', '!=', 'tolak')->latest()->get();

        return view('dashboard.karyawan.riwayat', compact('tunjangans'));
    }

    public function tolak()
    {
        $tanggal = request()->tanggal;
        $jenis_tunjangan = request()->jenis;
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->where('created_at', 'like', "%$tanggal%")->where('jenis_tunjangan', 'like', "%$jenis_tunjangan%")->where('status', 'tolak')->latest()->get();

        return view('dashboard.karyawan.riwayat-tolak', compact('tunjangans'));
    }
}
