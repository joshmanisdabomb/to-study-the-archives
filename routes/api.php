<?php

use App\Http\Controllers\BuildController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/service/pluralise', [ServiceController::class, 'pluralise'])->name('pluralise');
Route::post('/build/create', [BuildController::class, 'create'])->name('upload');
Route::post('/content/update', [ContentController::class, 'update'])->name('content');
