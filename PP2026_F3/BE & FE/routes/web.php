<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/karyawan.php';
require __DIR__.'/admin.php';

Route::get('/', function () {
    return view('karyawan.dashboard');
})->name('karyawan.dashboard');
