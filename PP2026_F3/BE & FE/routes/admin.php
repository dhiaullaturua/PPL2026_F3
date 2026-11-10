<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.monitor')->name('dashboard');
    Route::view('/monitor', 'admin.monitor')->name('monitor');
    Route::view('/rekap', 'admin.recap')->name('recap');
    Route::view('/keterlambatan', 'admin.lateness.index')->name('lateness.index');
    Route::view('/log-kedatangan', 'admin.attendance.logs')->name('attendance.logs');
    Route::view('/approval-lembur', 'admin.overtime.approval')->name('overtime.approval');
    Route::view('/kalender-libur', 'admin.calendar.index')->name('calendar.index');
});