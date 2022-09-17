<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;
use App\Models\ArticleTag;
use App\Models\Build;
use App\Models\PageTraffic;
use App\Models\Version;
use App\Models\VersionGroup;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DownloadsController extends Controller {

    public function home() {
        return view('downloads', [
            'groups' => VersionGroup::with([
                'versions' => function(Relation $query) { $query->whereNotNull('released_at'); },
                'versions.builds' => function(Relation $query) { $query->where(['nightly' => 0]); },
            ])->orderBy('order')->get()
        ]);
    }

    public function nightly() {
        return view('nightly', [
            'builds' => Build::where(['nightly' => 1])->with([
                'version',
                'version.group',
            ])->orderByDesc('run_number')->get()
        ]);
    }

    public function build(Build $build) {
        return Storage::download($build->path, $build->filename . '.jar');
    }

    public function source(Build $build) {
        if (!$build->source_path) throw new NotFoundHttpException('No sources available for this build.');
        return Storage::download($build->source_path, $build->filename . '-sources.jar');
    }

}
