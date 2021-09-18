<?php

namespace App\Handlers\Fragment;

use App\Handlers\Link\LinkHandler;
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
            $link = $text['link'];
            $handler = LinkHandler::getHandlerForType($link['type']);
            return $handler::getTextMarkup($link, $ret);
        }

        return $ret;
    }

}
