<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import Controller dari subfolder Karyawan dan Admin
use App\Http\Controllers\Api\Karyawan\AttendanceController as KaryawanAttendanceController;
use App\Http\Controllers\Api\Karyawan\OvertimeController;
use App\Http\Controllers\Api\Admin\CalendarController;
use App\Http\Controllers\Api\Admin\AttendanceRecapController;

/*
|--------------------------------------------------------------------------
| API Routes - Modul Kehadiran & Kalender Kerja (Kelompok F-3)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // FTR-KF3-01: Pencatatan Clock-In Harian Karyawan
    Route::post('/attendance/clock-in', [KaryawanAttendanceController::class, 'clockIn']);

    // FTR-KF3-01: Penyetelan Manual Status Kehadiran (Admin/COO)
    Route::patch('/attendance/status', [AttendanceRecapController::class, 'updateStatus']);

    // FTR-KF3-02: Pengajuan Permohonan Lembur Karyawan
    Route::post('/overtime/request', [OvertimeController::class, 'store']);

    // FTR-KF3-03: Manajemen Kalender Kerja & Libur (Admin)
    Route::post('/calendar/holidays', [CalendarController::class, 'store']);

});