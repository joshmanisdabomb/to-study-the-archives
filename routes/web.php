<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WikiController;
use App\Models\Version;
use App\Models\VersionGroup;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WikiController::class, 'home'])->name('home');

Route::get('/tag/{tag}', [TagController::class, 'view'])->where(['tag'], '[a-zA-Z0-9_]+')->name('tag');
Route::get('/category/{registry}', [CategoryController::class, 'view'])->where(['registry'], '[a-zA-Z0-9_]+')->name('category');

Route::get('/random', [ArticleController::class, 'random'])->name('random');

Route::get('/downloads', [DownloadsController::class, 'home'])->name('downloads');
Route::get('/downloads/nightly', [DownloadsController::class, 'nightly'])->name('nightly');
Route::get('/downloads/build/{build}', [DownloadsController::class, 'build'])->whereNumber(['build'])->name('build');
Route::get('/downloads/source/{build}', [DownloadsController::class, 'source'])->whereNumber(['build'])->name('source');

Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::get('/all', [ArticleController::class, 'list'])->name('all');

Route::get('/{slug1}/{slug2}', [ArticleController::class, 'view'])->where(['slug1', 'slug2'], '[a-zA-Z0-9_]+')->name('article');

//require __DIR__.'/auth.php';
