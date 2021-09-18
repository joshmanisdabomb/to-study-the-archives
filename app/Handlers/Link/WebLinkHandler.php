<?php

namespace App\Handlers\Link;

use Illuminate\Support\Str;

class WebLinkHandler extends LinkHandler {

    public static function getTextMarkup(array $link, string $content) : string {
        return '<a class="underline text-green-500 hover:text-green-800 visited:text-green-600" href="' . $link['url'] . '">' . $content . '</a>';
    }

    public static function getImageMarkup(array $link, string $content) : string {
        return '<a href="' . $link['url'] . '">' . $content . '</a>';
    }

}
