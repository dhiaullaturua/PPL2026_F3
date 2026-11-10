<?php

use Illuminate\Support\Facades\Route;

Route::view('/profil', 'karyawan.profile')->name('karyawan.profile');
Route::view('/notifikasi', 'karyawan.notifications')->name('karyawan.notifications');
Route::view('/pengumuman/verifikasi-jadwal', 'karyawan.announcements.schedule')->name('karyawan.announcements.schedule');
Route::view('/riwayat-presensi', 'karyawan.attendance.history')->name('karyawan.attendance.history');
Route::view('/lembur', 'karyawan.overtime.index')->name('karyawan.overtime.index');

Route::get('/presensi-masuk', function () {
    return view('karyawan.attendance.checkin', ['mode' => 'checkin']);
})->name('karyawan.attendance.checkin');

Route::get('/presensi-pulang', function () {
    return view('karyawan.attendance.checkin', ['mode' => 'checkout']);
})->name('karyawan.attendance.checkout');
