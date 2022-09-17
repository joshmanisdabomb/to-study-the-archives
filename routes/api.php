<?php

use App\Models\Build;
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
    $gradle = $request->file('gradle')->get();
    $lines = preg_split('/\r\n|\r|\n/', $gradle);
    foreach ($lines as $line) {
        if (strpos($line, 'minecraft_version=') === 0) {
            $mcver = substr($line, 18);
        } elseif (strpos($line, 'root_version=') === 0) {
            $modver = substr($line, 13);
        }
    }
    $build = Build::create([
        'nightly' => strpos($request->post('ref'), 'refs/tags/') !== 0,
        'mc_version' => $mcver ?? null,
        'mod_version' => $modver ?? null,
        'path' => $request->file('build')->store('builds'),
        'source_path' => $request->file('sources')->store('builds'),
        'run_number' => (int)$request->post('run_number'),
        'ref_name' => $request->post('ref_name'),
        'sha' => $request->post('sha'),
    ]);
    return response()->json($build);
});
