<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\HistoryBenefitController;
use App\Http\Controllers\RequestBenefitController;
use App\Http\Controllers\Admin\EmployeeControlller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDFBenefitController;

Route::permanentRedirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::resource('employee', EmployeeControlller::class);

        Route::get('/benefit', [BenefitController::class, 'index'])->name('benefit.index');
        Route::get('/benefit-done', [BenefitController::class, 'done'])->name('benefit.done');
        Route::post('/response/{benefit}', ResponseController::class)->name('response.store');

        Route::post('/benefit/sudah/pdf', [PDFBenefitController::class, 'done'])->name('benefit.pdf.done');
    });

    Route::middleware('role:employee')->group(function () {
        Route::resource('benefit', BenefitController::class)->except('index', 'show', 'create', 'edit');
        Route::get('/request-benefit', [RequestBenefitController::class, 'create'])->name('request');
        Route::get('/edit-request-benefit/{benefit}', [RequestBenefitController::class, 'edit'])->name('request-edit');
        Route::get('/history-benefit', HistoryBenefitController::class)->name('benefit.history');

        Route::get('employee/benefits/{employee}', function (\App\Models\Employee $employee) {
            return $employee->only('nik', 'kesehatan', 'bencana', 'transportasi', 'jabatan', 'makanan');
        });

        Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
        Route::post('notification/read/{notifications?}', [NotificationController::class, 'read'])->name('notification.read');
    });

    Route::post('/benefit/{benefit}/pdf', [PDFBenefitController::class, 'index'])->name('benefit.pdf');
    Route::get('/benefit/{benefit}', [BenefitController::class, 'show'])->name('benefit.show');
});

require __DIR__ . '/auth.php';
