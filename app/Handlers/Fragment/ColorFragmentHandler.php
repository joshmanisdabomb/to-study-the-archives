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
        return '<div class="wiki-color"><div style="background-color: ' . $fragment['hex'] . '"></div>' . $fragment['hex'] . '<span class="wiki-separator">-</span>' . $fragment['red'] . ', ' . $fragment['green'] . ', ' . $fragment['blue'] . '<span class="wiki-separator">-</span>' . $fragment['int'] . '</div>';
    }

}
