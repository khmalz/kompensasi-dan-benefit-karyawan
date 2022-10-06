<?php

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\DB;
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

// 3 Cara
// $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
// return substr(str_shuffle($chars), 0, 10);

// return "kd" . substr(str_replace('.', '', uniqid('', true)), 7, 7);

// return substr(uniqid(), 6);

// Penjelasan
// return uniqid();
// return substr(uniqid(), 8);


Route::get('/', function () {
    return Karyawan::with(['user', 'tunjangan'])->get();
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
        $tunjangans = Tunjangan::with('karyawan')->where('status', 'sudah')->get();
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
        $tunjangans = Tunjangan::where('karyawan_nik', auth()->user()->karyawan->nik)->get();
        return view('dashboard.karyawan.riwayat', compact('tunjangans'));
    });

    Route::get('/dibaca/{notifications:id}', function ($id) {
        if ($id) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return back();
    });
});

// Route::get('/dashboard', function () {
//     return view('dashboard.layouts.main');
// });
