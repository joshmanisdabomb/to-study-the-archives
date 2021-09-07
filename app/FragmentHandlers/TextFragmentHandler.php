<?php

namespace App\FragmentHandlers;

use App\Models\Article;
use App\Models\ArticleFragment;
use RuntimeException;

class TextFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $translations = $fragment['translations']['en_us'];
        $content = self::getTextMarkup($fragment['content'], $translations);
        $content = sprintf($content, ...array_map(fn($insert) => self::getTextMarkup($insert, $translations), $fragment['inserts']));
        return $content;
    }

    private static function getTextMarkup(array $text, array $translations) : string {
        if (isset($text['text'])) $ret = $text['text'];
        else if (isset($text['translate'])) $ret = $translations[$text['translate']];
        else throw new RuntimeException("Could not parse text.");

        $ret = nl2br($ret);

        if (isset($text['link'])) {
            $parts = explode('/', $text['link'], 2);
            $slug1 = explode(':', $parts[0], 2)[1];
            $slug2 = explode(':', $parts[1], 2)[1];
            $article = Article::where('slug1', $slug1)->where('slug2', $slug2)->first();
            return '<a class="underline text-' . ($article ? 'blue-600' : 'red-400') . ' hover:text-' . ($article ? 'blue-800' : 'red-600') . ' visited:text-' . ($article ? 'purple-600' : 'red-900') . '" href="' . route('article', compact('slug1', 'slug2')) . '">' . $ret . '</a>';
        }

        return $ret;
    }

}
