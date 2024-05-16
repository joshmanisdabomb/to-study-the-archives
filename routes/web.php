<?php

use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/downloads', [DownloadsController::class, 'index'])->name('downloads');
Route::get('/downloads/{file}', [DownloadsController::class, 'view'])->name('download');
