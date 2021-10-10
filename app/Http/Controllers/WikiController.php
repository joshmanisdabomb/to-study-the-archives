<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleRedirect;
use App\Models\ArticleTag;
use App\Models\PageTraffic;
use App\Models\Version;
use Illuminate\Support\Facades\DB;

class WikiController extends Controller {

    public function home() {
        return view('home', [
            'articles' => Article::query()->whereNull('deleted_at')->count(),
            'tags' => ArticleTag::query()->select(['tag'])->distinct()->orderBy('tag')->pluck('tag'),
            'registries' => Article::query()->select(['slug1'])->distinct()->whereNull('deleted_at')->orderBy('slug1')->pluck('slug1'),
            'popular' => Article::query()->whereNull('deleted_at')->join('page_traffic', DB::raw('CONCAT(articles.slug1, "/", articles.slug2)'), '=', 'page_traffic.page')->orderByDesc('counter')->orderBy('name')->get(),
            'guides' => Article::where('registry', 'lcc:guide')->whereNull('deleted_at')->orderBy('name')->get(),
            'current' => Version::latest('released_at')->first(),
        ]);
    }

}
