<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Tanggapan;
use App\Models\Tunjangan;
use Illuminate\Http\Request;
use App\Notifications\TunjanganNotification;
use Illuminate\Support\Facades\Notification;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = User::find($request->id);

        $tunjangan =  Tunjangan::where('kode', $request->kode);
        $karyawan = Karyawan::where('nik', $tunjangan->first()->karyawan_nik);
        $sisaTunjangan = $karyawan->first()["$request->jenis_tunjangan"] - $request->besar_tunjangan;

        if ($sisaTunjangan < 0) {
            return back();
        }

        if (empty(Tanggapan::where('kode_tunjangan', $request->kode)->first())) {
            Tanggapan::create([
                'kode_tunjangan' => $request->kode,
                'pesan' => $request->pesan,
            ]);
        } else {
            Tanggapan::where('kode_tunjangan', $request->kode)->update([
                'pesan' => $request->pesan,
            ]);
        }

        $tunjangan->update([
            'status' => $request->status,
        ]);

        if ($tunjangan->first()->status == 'sudah') {
            // Menggunakan versi nama_tunjangan dengan lengkap yakni ada kata (tunjangan_)

            $karyawan = Karyawan::where('nik', $tunjangan->first()->karyawan_nik);
            $karyawan->update([
                "$request->jenis_tunjangan" => $karyawan->first()["$request->jenis_tunjangan"] - $request->besar_tunjangan
            ]);
        }

        Notification::send($user, new TunjanganNotification($request->kode, $request->status));

        return redirect('tunjangan')->with('success', 'Berhasil Mengirim Tanggapan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function show(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tanggapan  $tanggapan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }
}
