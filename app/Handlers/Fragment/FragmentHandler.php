<?php

namespace App\Handlers\Fragment;

use Illuminate\Support\Str;

abstract class FragmentHandler {

    public static function getHandlerForType(string $type) : string {
        return '\\App\\Handlers\\Fragment\\' . Str::studly($type) . 'FragmentHandler';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -strlen("FragmentHandler"));
        return Str::snake($shortName);
    }

    public static abstract function getMarkup(array $fragment) : string;

}
