<?php

namespace App\FragmentHandlers;

use App\Models\ArticleFragment;
use Illuminate\Support\Str;

abstract class FragmentHandler {

    public static function getHandlerForType(string $type) : string {
        return '\\App\\FragmentHandlers\\' . Str::studly($type) . 'FragmentHandler';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -11);
        return Str::snake($shortName);
    }

    public static abstract function getMarkup(ArticleFragment $fragment) : string;

}
