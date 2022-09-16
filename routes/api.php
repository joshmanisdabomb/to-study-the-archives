<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/pluralise', function (Request $request) {
    return response()->json(collect($request->json()->all())->map(fn(string $value) => Str::plural($value)));
});

Route::post('/upload-build', function (Request $request) {
    if ($request->post('key', '') !== env('API_KEY')) throw new AuthenticationException;
    $request->file('jar')->store('builds/ci');
    $request->file('storage')->store('builds/ci');
    return response()->json(['success' => 1]);
});
