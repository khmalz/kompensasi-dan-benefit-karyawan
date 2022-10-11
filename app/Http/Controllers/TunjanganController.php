<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('status', '!=', 'sudah')->latest()->get();

        if ($pencarian && $tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('status', '!=', 'sudah')->latest()->get();
        } else if ($tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->where('created_at', 'like', "%$tanggal%")->where('status', '!=', 'sudah')->latest()->get();
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
        //
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
        //
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
        $user = User::find($tunjangan->karyawan->user_id);
        File::delete(public_path("images/$tunjangan->bukti"));

        Notification::send($user, new TunjanganNotification($tunjangan->kode, "kelebihan"));

        return redirect('/tunjangan');
    }

    public function pdf(Tunjangan $tunjangan)
    {
        // return view('pdf', compact('tunjangan'));
        $pdf = Pdf::loadView('pdf', compact('tunjangan'));
        return $pdf->download('tunjangan_' . $tunjangan->kode . '.pdf');
    }
}
