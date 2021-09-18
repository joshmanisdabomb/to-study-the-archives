<?php

namespace App\Handlers\Link;

use App\Models\Article;
use Illuminate\Support\Str;

class SelfLinkHandler extends LinkHandler {

    private static function getArticle(string $to, &$slug1, &$slug2) : ?Article {
        $parts = explode('::', $to, 2);
        $slug1 = explode(':', $parts[0], 2)[1];
        $slug2 = explode(':', $parts[1], 2)[1];
        return Article::where('slug1', $slug1)->where('slug2', $slug2)->first();
    }

    public static function getTextMarkup(array $link, string $content) : string {
        $article = static::getArticle($link['to'], $slug1, $slug2);
        return '<a class="underline text-' . ($article ? 'blue-500' : 'red-400') . ' hover:text-' . ($article ? 'blue-800' : 'red-700') . ' visited:text-' . ($article ? 'blue-600' : 'red-500') . '" href="' . route('article', compact('slug1', 'slug2')) . '">' . $content . '</a>';
    }

    public static function getImageMarkup(array $link, string $content) : string {
        $article = static::getArticle($link['to'], $slug1, $slug2);
        return '<a href="' . route('article', compact('slug1', 'slug2')) . '">' . $content . '</a>';
    }

}
