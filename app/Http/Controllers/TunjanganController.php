<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Tunjangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use App\Notifications\TunjanganNotification;
use Illuminate\Support\Facades\Notification;

class TunjanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('admin');
        $pencarian = $request->cari;
        $tanggal = $request->tanggal;

        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->whereIn('status', ['belum', 'sedang'])->latest()->get();

        if ($pencarian && $tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->whereIn('status', ['belum', 'sedang'])->latest()->get();
        } else if ($tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->where('created_at', 'like', "%$tanggal%")->whereIn('status', ['belum', 'sedang'])->latest()->get();
        }

        return view('dashboard.admin.tunjangan.index', compact('tunjangans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function tolak()
    {
        $tanggal = request()->tanggal;

        $tunjangans = Tunjangan::where('status', 'tolak')->latest()->get();

        if ($tanggal) {
            $tunjangans = Tunjangan::where('created_at', 'like', "%$tanggal%")->where('status', 'tolak')->latest()->get();
        }
        return view('dashboard.karyawan.riwayat-tolak', compact('tunjangans'));
    }

    public function sudah()
    {
        $pencarian = request()->cari;
        $tanggal = request()->tanggal;

        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('status', 'sudah')->latest()->get();

        if ($pencarian && $tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('status', 'sudah')->latest()->get();
        } else if ($tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->where('created_at', 'like', "%$tanggal%")->where('status', 'sudah')->latest()->get();
        }

        return view('dashboard.admin.tunjangan.index-sudah', compact('tunjangans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tunjangan  $tunjangan
     * @return \Illuminate\Http\Response
     */

    public function show(Tunjangan $tunjangan)
    {
        // return $tunjangan->load('karyawan.user', 'tanggapan');
        return view('dashboard.admin.tunjangan.detail', compact('tunjangan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tunjangan  $tunjangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tunjangan $tunjangan)
    {
        if ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] >= $tunjangan->besar_tunjangan) {
            return back();
        }

        return view('dashboard.karyawan.edit-tunjangan', compact('tunjangan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tunjangan  $tunjangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tunjangan $tunjangan)
    {
        $request->validate([
            'jenis_tunjangan' => 'required',
        ]);

        $karyawan = Karyawan::where('nik', $request->karyawan_nik)->value($request->jenis_tunjangan);

        $request->validate([
            'besar_tunjangan' => 'required|lte:' . $karyawan,
            'pesan' => 'required',
            'bukti' => 'image|file'
        ]);

        if ($request->file('bukti')) {
            File::delete(public_path("images/$tunjangan->bukti"));

            $bukti = $request->file('bukti')->store('bukti');
        }

        Tunjangan::where('kode', $request->kode)->update([
            'jenis_tunjangan' => $request->jenis_tunjangan,
            'besar_tunjangan' => $request->besar_tunjangan,
            'status' => $request->status,
            'bukti' => $bukti ?? $tunjangan->bukti,
        ]);

        return redirect('riwayat-tunjangan')->with('success', 'Berhasil Mengedit Tunjangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tunjangan  $tunjangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tunjangan $tunjangan)
    {
        Tunjangan::destroy($tunjangan->kode);
        File::delete(public_path("images/$tunjangan->bukti"));

        return redirect('/riwayat-tunjangan');
    }

    public function pdf(Tunjangan $tunjangan)
    {
        // return view('pdf', compact('tunjangan'));
        $pdf = Pdf::loadView('pdf', compact('tunjangan'));
        return $pdf->download('tunjangan_' . $tunjangan->kode . '.pdf');
    }
}
