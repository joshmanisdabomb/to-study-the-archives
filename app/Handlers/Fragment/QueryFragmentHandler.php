<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class QueryFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $articles = Article::query()->whereNull('deleted_at');
        $articles->whereHas('tags', function(Builder $query) use ($fragment) {
            foreach ($fragment['tags'] as $tagOr) {
                $query->whereIn('tag', $tagOr);
            }
        });
        foreach ($fragment['registries'] as $registryOr) {
            $articles->whereIn('registry', $registryOr);
        }
        return FragmentHandler::renderArticleList($articles->get()->each(function(Article $article) { $article->link = true; }));
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
