<?php

namespace App\Handlers\Fragment;

use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class BulletFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['fragments'] as $fragment) {
            $content .= FragmentHandler::render($fragment, fn(string $content) => '<li>' . $content . '</li>');
        }
        return '<ul class="list-disc pl-4">' . $content . '</ul>';
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
