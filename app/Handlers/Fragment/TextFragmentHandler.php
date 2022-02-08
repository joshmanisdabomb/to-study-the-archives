<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleFragment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use RuntimeException;
use Throwable;

class TextFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        return self::displayText($fragment['content']);
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<p class="mb-2">' . $content . '</p>';
    }

    public static function displayJsonText(string $markup) : string {
        return self::displayText(json_decode($markup, true));
    }

    public static function displayText(array $content) : string {
        if (isset($content['text'])) $ret = $content['text'];
        else if (isset($content['translate'])) $ret = __("ingame." . $content['translate']);
        else throw new RuntimeException("Could not parse text.");

        return nl2br($ret);
    }

}
