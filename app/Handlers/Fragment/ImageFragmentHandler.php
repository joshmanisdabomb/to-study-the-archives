<?php

namespace App\Handlers\Fragment;

use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class ImageFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['images'] as $k => $image) {
            $content .= '<div class="wiki-flick-entry" style="display: ' . ($k == 0 ? 'block' : 'none') . ';"><img src="';
            if ($image['type'] === 'static') {
                $content .= asset('images/static/' . $image['location']);
            } elseif ($image['type'] === 'article') {
                $parts = explode('::', $image['location'], 2);
                $registry = explode(':', $parts[0], 2);
                $key = explode(':', $parts[1], 2);
                $path = 'images/models/' . $key[0] . '/' . $registry[1] . '/' . $key[1] . '.png';
                $content .= asset($path);
            }
            $content .= '" alt="';
            if (isset($fragment['caption'])) {
                $content .= strip_tags(FragmentHandler::render($fragment['caption'], fn(string $content) => strip_tags($content)));
            }
            $content .= '">';
            if (isset($fragment['caption'])) {
                $content .= strip_tags(FragmentHandler::render($fragment['caption'], fn(string $content) => '<div class="image-flick-caption">' . $content . '</div>'));
            }
            $content .= '</div>';
        }
        return '<div class="wiki-image ' . ($fragment['images'] > 1 ? 'wiki-flick' : '') . '">' . $content . '</div>';
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
