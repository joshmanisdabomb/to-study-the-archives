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

class StackFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        return '<div class="gui-stacks">' . collect($fragment['stacks'])->map(fn(array $stack) => RecipeHandler::renderSlot((Ingredient::fromArray($stack))->setNameFrom($fragment['translations'])->setLinkFrom($fragment['links'])))->implode('') . '</div>';
    }

}
