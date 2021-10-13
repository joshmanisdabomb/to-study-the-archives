<?php

namespace App\Handlers\Fragment;

use App\Handlers\Recipe\RecipeHandler;
use App\Models\Article;
use App\Models\ArticleFragment;
use App\Models\Ingredient;
use Jenssegers\Model\Model;
use RuntimeException;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class ColorFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        return '<div class="wiki-color"><div class="wiki-color-swatch" style="background-color: ' . $fragment['hex'] . '"></div><span class="wiki-color-details">' . $fragment['hex'] . '<span class="wiki-separator">-</span>' . $fragment['red'] . ', ' . $fragment['green'] . ', ' . $fragment['blue'] . '<span class="wiki-separator">-</span>' . $fragment['int'] . '</span></div>';
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
