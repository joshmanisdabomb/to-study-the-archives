<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class ListFragmentHandler extends FragmentHandler {

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
        return '<div class="wiki-article-list grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">' . $articles->get()->map(function (Article $article) {
            return '<a class="max-w w-full lg:max-w-full border border-gray-300 bg-white rounded text-indigo-500 hover:text-indigo-800 visited:text-indigo-600 flex" href="' . route('article', ['slug1' => $article->slug1, 'slug2' => $article->slug2]) . '">' .
                ($article->image !== null ? '<div class="wiki-article-list-image bg-gray-200" style="background-image: url(\'' . $article->image . '\')"></div>' : '') .
                '<div class="px-4 py-3 flex-grow flex flex-col leading-normal w-full border-gray-400 border-l-4">
                    <div class="font-bold text-xl">' . $article->name . '</div>
                </div>
            </a>';
        })->join('') . '</div>';
    }

}
