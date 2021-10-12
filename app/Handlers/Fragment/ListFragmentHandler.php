<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleRedirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class ListFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $references = collect($fragment['articles']);
        $locations = $references->pluck('location');
        $references = $references->keyBy('location');

        $articles = Article::query()->whereIn(DB::raw('CONCAT(articles.registry, "::", articles.key)'), $locations)->whereNull('deleted_at')->get();

        $redirects = ArticleRedirect::query()->whereIn(DB::raw('CONCAT(article_redirects.registry, "::", article_redirects.key)'), $locations)->whereNull('deleted_at')->get();
        $redirects = $redirects->map(fn(ArticleRedirect $redirect) => $references[$redirect->location]['reroute'] ? $redirect->article : $redirect);

        $sort = $locations->flip();
        return FragmentHandler::renderArticleList(
            $articles
                ->merge($redirects)
                ->each(function($item) use ($references) {
                    $item->link = $references[$item->location]['link'];
                })
                ->sortBy(fn($item) => $sort[$item->location])
        );
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
