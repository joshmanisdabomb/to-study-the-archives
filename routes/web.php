<?php

use App\Models\Version;
use App\Models\VersionGroup;
use Illuminate\Database\Eloquent\Builder;
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

Route::get('/', function() {
    return view('dashboard');
})->name('home');

Route::get('/downloads', function() {
    return view('downloads', [
        'groups' => VersionGroup::whereHas('versions', function(Builder $query) {})->where([])->orderBy('order')->get()
    ]);
})->name('downloads');

//require __DIR__.'/auth.php';
