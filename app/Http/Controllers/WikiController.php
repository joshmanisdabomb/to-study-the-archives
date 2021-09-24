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
            'articles' => Article::count(),
            'tags' => ArticleTag::query()->select(['tag'])->distinct()->pluck('tag'),
            'registries' => Article::query()->select(['slug1'])->distinct()->pluck('slug1'),
            'popular' => Article::query()->join('page_traffic', DB::raw('CONCAT(articles.slug1, "/", articles.slug2)'), '=', 'page_traffic.page')->orderByDesc('counter')->get(),
            'guides' => Article::where('registry', 'lcc:guide')->get(),
            'current' => Version::latest('released_at')->first(),
        ]);
    }

}
