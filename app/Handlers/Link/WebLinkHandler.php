<?php

namespace App\Handlers\Link;

use Illuminate\Support\Str;

class WebLinkHandler extends LinkHandler {

    public static function getTextMarkup(array $link, string $content) : string {
        return '<a target="_blank" class="underline text-green-500 hover:text-green-800 visited:text-green-600" href="' . static::getUrl($link) . '">' . $content . '</a>';
    }

    public static function getImageMarkup(array $link, string $content) : string {
        return '<a target="_blank" href="' . static::getUrl($link) . '">' . $content . '</a>';
    }

    protected static function getUrl(array $link) {
        $target = $link['target'] ?? null;
        return $link['url'] . ($target ? ('#' . $target) : '');
    }

}
