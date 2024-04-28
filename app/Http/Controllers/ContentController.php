<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function update(Request $request) {
        if ($request->post('key', '') !== env('API_KEY')) throw new AuthenticationException;
        return response()->json(['success' => true]);
    }
}
