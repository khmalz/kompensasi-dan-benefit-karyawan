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
        $jenis_tunjangan = $request->jenis;

        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('jenis_tunjangan', 'like', "%$jenis_tunjangan%")->whereIn('status', ['belum', 'sedang'])->latest()->get();

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
        $pencarian = request()->cari;
        $tanggal = request()->tanggal;
        $jenis_tunjangan = request()->jenis;

        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('jenis_tunjangan', 'like', "%$jenis_tunjangan%")->where('status', 'tolak')->latest()->get();

        return view('dashboard.karyawan.riwayat-tolak', compact('tunjangans'));
    }

    public function sudah()
    {
        $pencarian = request()->cari;
        $tanggal = request()->tanggal;
        $jenis_tunjangan = request()->jenis;

        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('jenis_tunjangan', 'like', "%$jenis_tunjangan%")->where('status', 'sudah')->latest()->get();

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
        $sisaTunjangan = $tunjangan->karyawan[$tunjangan->jenis_tunjangan];
        return view('dashboard.admin.tunjangan.detail', compact('tunjangan', 'sisaTunjangan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tunjangan  $tunjangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tunjangan $tunjangan)
    {
        /**
         * Hanya status yang ditolak yang boleh masuk halaman
         * Hanya yang Tunjangannya lebih kecil dari permintaannya dan TUNJANGANNYA BELUM HABIS yang bisa masuk
         */

        $this->authorize('karyawan');

        $sisaTunjangan = $tunjangan->karyawan[$tunjangan->jenis_tunjangan];

        if ($tunjangan->status === 'tolak' || $sisaTunjangan < $tunjangan->besar_tunjangan) {
            if ($sisaTunjangan <= 0) {
                return back();
            }

            if ($tunjangan->status == 'sedang' || $tunjangan->status == 'sudah') {
                return back();
            }

            return view('dashboard.karyawan.edit-tunjangan', compact('tunjangan', 'sisaTunjangan'));
        }

        return back();
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
            'pesan' => $request->pesan,
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
