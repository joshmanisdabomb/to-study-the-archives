<?php

namespace App\Http\Controllers;

use App\Models\Build;
use App\Models\BuildFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class DownloadsController extends Controller
{
    public function index(): View {
        $all = Build::with(['mod', 'version', 'files', 'mod.builds'])->orderByDesc('released_at')->get();

        $modkey = $all->reverse();
        $stable = $modkey->where('nightly', '=', false)->keyBy('mod_identifier');
        $nightly = $modkey->where('nightly', '=', true)->keyBy('mod_identifier');

        return view('downloads', compact('all', 'stable', 'nightly'));
    }

    public function view(BuildFile $file): Response {
        return Storage::download($file->path, $file->filename . '.jar');
    }
}
