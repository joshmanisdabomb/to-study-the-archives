<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleFragment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use RuntimeException;

class TextFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = self::getTextMarkup($fragment['content']);
        $content = sprintf($content, ...array_map(fn(array $insert) => self::getTextMarkup($insert), $fragment['inserts']));
        return $content;
    }

    private static function getTextMarkup(array $text) : string {
        if (isset($text['text'])) $ret = $text['text'];
        else if (isset($text['translate'])) {
            $translations = $text['translations'];
            $ret = $translations[App::currentLocale()] ?? $translations[Config::get('fallback_locale')];
        }
        else throw new RuntimeException("Could not parse text.");

        $ret = nl2br($ret);

        if (isset($text['link'])) {
            $parts = explode('/', $text['link'], 2);
            $slug1 = explode(':', $parts[0], 2)[1];
            $slug2 = explode(':', $parts[1], 2)[1];
            $article = Article::where('slug1', $slug1)->where('slug2', $slug2)->first();
            return '<a class="underline text-' . ($article ? 'blue-500' : 'red-400') . ' hover:text-' . ($article ? 'blue-800' : 'red-700') . ' visited:text-' . ($article ? 'blue-600' : 'red-500') . '" href="' . route('article', compact('slug1', 'slug2')) . '">' . $ret . '</a>';
        }

        return $ret;
    }

}
