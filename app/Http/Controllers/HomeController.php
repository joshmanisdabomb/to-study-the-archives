<?php

namespace App\Http\Controllers;

use App\Models\Mod;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View {
        $mods = Mod::with('latest.build.files')->orderBy('name')->get()->keyBy('identifier');

        return view('home', compact('mods'));
    }
}
