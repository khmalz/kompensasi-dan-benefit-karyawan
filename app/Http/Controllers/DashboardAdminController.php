<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pencarian = request()->cari;
        $karyawans = Karyawan::where('nama', 'like', "%$pencarian%")->orderBy('user_id', 'asc')->get();
        return view('dashboard.admin.karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.karyawan.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new User;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);
        $model->save();

        $user = User::latest()->first();
        $karyawan = new Karyawan;
        $karyawan->nik = $request->nik;
        $karyawan->user_id = $user->id;
        $karyawan->nama = $request->name;
        $karyawan->status = $request->status;
        $karyawan->lokasi = $request->lokasi;
        $karyawan->tanggal_masuk = $request->tanggal_masuk;
        $karyawan->save();

        return redirect('dashboardAdmin')->with('added', 'Berhasil Menambahkan Data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan)
    {
        return view('dashboard.admin.karyawan.detail', [
            'karyawan' => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        return view('dashboard.admin.karyawan.edit', [
            'karyawan' => $karyawan
        ]);
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
        Karyawan::where('nik', $karyawan->nik)->update([
            'nik' => $request->nik,
            'nama' => $request->name,
            'status' => $request->status,
            'lokasi' => $request->lokasi,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        User::where('id', $karyawan->user_id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect('dashboardAdmin')->with('updated', 'Berhasil Mengedit Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        User::destroy($karyawan->user_id);
        return redirect('dashboardAdmin')->with('deleted', 'Berhasil Menghapus Data');
    }
}
