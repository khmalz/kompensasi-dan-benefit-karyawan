<?php

namespace App\Http\Controllers;

use App\Models\Tunjangan;
use Illuminate\Http\Request;

class RiwayatTunjanganController extends Controller
{
    public function index()
    {
        $tanggal = request()->tanggal;
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->where('status', '!=', 'tolak')->latest()->get();

        if ($tanggal) {
            $tunjangans = Tunjangan::where('created_at', 'like', "%$tanggal%")->where('karyawan_nik', auth()->user()->karyawan->nik)->where('status', '!=', 'tolak')->latest()->get();
        }
        return view('dashboard.karyawan.riwayat', compact('tunjangans'));
    }

    public function tolak()
    {
        $tanggal = request()->tanggal;
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->where('status', 'tolak')->latest()->get();

        if ($tanggal) {
            $tunjangans = Tunjangan::where('created_at', 'like', "%$tanggal%")->where('karyawan_nik', auth()->user()->karyawan->nik)->where('status', 'tolak')->latest()->get();
        }
        return view('dashboard.karyawan.riwayat-tolak', compact('tunjangans'));
    }
}
