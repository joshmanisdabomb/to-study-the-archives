<?php

namespace App\Handlers\Fragment;

use App\Models\Article;
use App\Models\ArticleFragment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use RuntimeException;
use Throwable;

class ParagraphFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['fragments'] as $f) {
            $content .= FragmentHandler::render($f, fn(string $content) => $content);
        }
        return $content;
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<p class="mb-2">' . $content . '</p>';
    }

}
