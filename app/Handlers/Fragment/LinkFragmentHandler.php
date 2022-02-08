<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleFragment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use RuntimeException;
use Throwable;

class LinkFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['fragments'] as $f) {
            $content .= FragmentHandler::render($f, fn(string $content) => $content);
        }
        $parts = explode('::', $fragment['link'], 2);
        $registry = explode(':', $parts[0], 2);
        $key = explode(':', $parts[1], 2);
        $article = Article::where('slug1', $registry[1])->where('slug2', $key[1])->first();
        if ($article) {
            return '<a class="underline text-blue-500 hover:text-blue-800 visited:text-blue-600" href="' . route('article', ['slug1' => $registry[1], 'slug2' => $key[1]]) . '">' . $content . '</a>';
        } else if ($registry[0] === "minecraft" && $key[0] === "minecraft") {
            return '<a target="_blank" class="underline text-green-500 hover:text-green-800 visited:text-green-600" href="https://minecraft.fandom.com/wiki/' . $key[1] . '">' . $content . '</a>';
        } else {
            return '<a class="underline text-red-400 hover:text-red-700 visited:text-red-500" href="' . route('article', ['slug1' => $registry[1], 'slug2' => $key[1]]) . '">' . $content . '</a>';
        }
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return $content;
    }

}
