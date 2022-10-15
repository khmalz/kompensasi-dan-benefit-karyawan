<?php

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
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RiwayatTunjanganController;

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

    // return DB::table('users')->rightJoin('karyawans', 'karyawans.user_id', 'users.id')->get();
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::middleware('admin')->group(function () {
        Route::resource('/dashboardAdmin', DashboardAdminController::class)->except('show', 'edit', 'update', 'destroy');
        Route::get('/dashboardAdmin/{karyawan}', [DashboardAdminController::class, 'show']);
        Route::get('/dashboardAdmin/{karyawan}/edit', [DashboardAdminController::class, 'edit']);
        Route::put('dashboardAdmin/{karyawan}', [DashboardAdminController::class, 'update']);
        Route::delete('dashboardAdmin/{karyawan:user_id}', [DashboardAdminController::class, 'destroy']);

        Route::get('/tunjangan/tolak', [TunjanganController::class, 'tolak']);
        Route::get('/tunjangan/sudah', [TunjanganController::class, 'sudah']);

        Route::resource('/tanggapan', TanggapanController::class);
    });

    Route::middleware('karyawan')->group(function () {
        Route::patch('ganti-password', [PasswordController::class, 'update'])->name('ganti-password');

        Route::resource('/dashboardKaryawan', DashboardKaryawanController::class);

        Route::get('/riwayat-tunjangan', [RiwayatTunjanganController::class, 'index']);
        Route::get('/riwayat-tunjangan/ditolak', [RiwayatTunjanganController::class, 'tolak']);

        Route::get('/dibaca/{notifications?}', function ($id = null) {
            if ($id) {
                auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
            } else {
                auth()->user()->unreadNotifications->markAsRead();
            }
            return back();
        });
    });

    Route::post('/tunjangan/pdf/{tunjangan}', [TunjanganController::class, 'pdf']);
    Route::resource('/tunjangan', TunjanganController::class)->except('pdf');

    Route::get('karyawan/{karyawan}', function (Karyawan $karyawan) {
        return $karyawan->load('user');
    });
});
