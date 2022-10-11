<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Tunjangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.karyawan.index');
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
        $request->validate([
            'jenis_tunjangan' => 'required',
        ]);

        $karyawan = Karyawan::where('nik', $request->karyawan_nik)->value($request->jenis_tunjangan);

        $request->validate([
            'besar_tunjangan' => 'required|lte:' . $karyawan,
            'pesan' => 'required',
            'bukti' => 'required|image|file'
        ]);

        // $request['kode'] = $this->genKodeTunjangan();
        do {
            $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $request['kode'] = substr(str_shuffle($chars), 0, 10);
        } while (Tunjangan::where('kode', $request['kode'])->exists());

        $tunjangan = new Tunjangan;
        $tunjangan->kode = $request->kode;
        $tunjangan->karyawan_nik = $request->karyawan_nik;
        $tunjangan->jenis_tunjangan = $request->jenis_tunjangan;
        $tunjangan->besar_tunjangan = $request->besar_tunjangan;
        $tunjangan->status = $request->status;
        $tunjangan->pesan = $request->pesan;
        if ($request->file('bukti')) {
            $tunjangan['bukti'] = $request->file('bukti')->store('bukti');
        }
        $tunjangan->save();

        return redirect('dashboardKaryawan')->with('added', 'Berhasil Mengirim Permintaan');
    }

    // private function genKodeTunjangan()
    // {
    //     $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $request['kode'] = substr(str_shuffle($chars), 0, 10);

    //     $validate = !Validator::make(Request()->only('kode'), [
    //         'kode' => 'unique:tunjangans,kode'
    //     ])->fails();

    //     return $validate ? $kode : $this->genKodeTunjangan();
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        //
    }
}
