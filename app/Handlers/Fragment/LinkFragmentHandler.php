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
        $properties = static::getLinkProperties($fragment['link']);
        if (!empty($fragment['target'])) {
            $properties['href'] .= '#' . $fragment['target'];
        }
        return "<a target='{$properties['target']}' class='underline text-{$properties['color']} hover:text-{$properties['hover_color']} visited:text-{$properties['visited_color']}' href='{$properties['href']}'>" . $content . '</a>';
    }

    public static function getLinkProperties(string $link) : array {
        $parts = explode('::', $link, 2);
        $registry = explode(':', $parts[0], 2);
        $key = explode(':', $parts[1], 2);
        $article = Article::where('slug1', $registry[1])->where('slug2', $key[1])->first();
        if ($article) {
            return [
                'target' => '_self',
                'color' => 'blue-500',
                'hover_color' => 'blue-800',
                'visited_color' => 'blue-600',
                'href' => route('article', ['slug1' => $registry[1], 'slug2' => $key[1]])
            ];
        } else if ($registry[0] === "minecraft" && $key[0] === "minecraft") {
            return [
                'target' => '_blank',
                'color' => 'green-500',
                'hover_color' => 'green-800',
                'visited_color' => 'green-600',
                'href' => 'https://minecraft.fandom.com/wiki/' . $key[1]
            ];
        } else {
            return [
                'target' => '_self',
                'color' => 'red-400',
                'hover_color' => 'red-700',
                'visited_color' => 'red-500',
                'href' => route('article', ['slug1' => $registry[1], 'slug2' => $key[1]])
            ];
        }
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return $content;
    }

}
