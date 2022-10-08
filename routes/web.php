<?php

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\TunjanganController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardKaryawanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (!Gate::allows('admin', auth()->user())) {
        // abort(403);
        return redirect('login');
    }

    return Karyawan::with(['user', 'tunjangan'])->get();

    // return $tunjangan_karyawan->tunjangan_kesehatan - $total_tunjangan;
    // return DB::table('users')->rightJoin('karyawans', 'karyawans.user_id', 'users.id')->get();
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    // Halaman Data Karyawan
    Route::resource('/dashboardAdmin', DashboardAdminController::class)->except('show', 'edit', 'update', 'destroy');

    Route::get('/dashboardAdmin/{karyawan}', [DashboardAdminController::class, 'show']);
    Route::get('/dashboardAdmin/{karyawan}/edit', [DashboardAdminController::class, 'edit']);
    Route::put('dashboardAdmin/{karyawan}', [DashboardAdminController::class, 'update']);
    Route::delete('dashboardAdmin/{karyawan:user_id}', [DashboardAdminController::class, 'destroy']);

    // Halaman Permintaan Tunjangan
    Route::get('/tunjangan-sudah', function () {
        $pencarian = request()->cari;
        $tanggal = request()->tanggal;
        $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('status', 'sudah')->get();

        if ($pencarian && $tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->whereRelation('karyawan', 'nama', 'like', "%$pencarian%")->where('created_at', 'like', "%$tanggal%")->where('status', 'sudah')->get();
        } else if ($tanggal) {
            $tunjangans = Tunjangan::with('karyawan')->where('created_at', 'like', "%$tanggal%")->where('status', 'sudah')->get();
        }

        return view('dashboard.admin.tunjangan.index-sudah', compact('tunjangans'));
    });
    Route::resource('/tanggapan', TanggapanController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/tunjangan/pdf/{tunjangan}', [TunjanganController::class, 'pdf']);
    Route::resource('/tunjangan', TunjanganController::class)->except('pdf');
});

Route::middleware(['auth', 'karyawan'])->group(function () {
    Route::resource('/dashboardKaryawan', DashboardKaryawanController::class);

    Route::get('/riwayat-tunjangan', function () {
        $tanggal = request()->tanggal;
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->get();

        if ($tanggal) {
            $tunjangans = Tunjangan::where('created_at', 'like', "%$tanggal%")->where('karyawan_nik', auth()->user()->karyawan->nik)->get();
        }
        return view('dashboard.karyawan.riwayat', compact('tunjangans'));
    });

    Route::get('/dibaca/{notifications}', function ($id) {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    });
});
