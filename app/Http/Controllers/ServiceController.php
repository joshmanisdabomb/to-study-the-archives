<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function pluralise(Request $request) {
        return response()->json(collect($request->json()->all())->map(fn(string $value) => Str::plural($value)));
    }
}
