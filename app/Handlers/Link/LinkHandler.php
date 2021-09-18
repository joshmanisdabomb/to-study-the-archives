<?php

namespace App\Handlers\Link;

use Illuminate\Support\Str;

abstract class LinkHandler {

    public static function getHandlerForType(string $type) : string {
        return '\\App\\Handlers\\Link\\' . Str::studly($type) . 'LinkHandler';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -strlen("LinkHandler"));
        return Str::snake($shortName);
    }

    public static abstract function getTextMarkup(array $link, string $content) : string;

    public static abstract function getImageMarkup(array $link, string $content) : string;

}
