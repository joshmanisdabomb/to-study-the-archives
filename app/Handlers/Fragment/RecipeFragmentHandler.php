<?php

namespace App\Handlers\Fragment;

use App\Handlers\Recipe\RecipeHandler;
use App\Models\Article;
use App\Models\ArticleFragment;
use RuntimeException;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class RecipeFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['recipes'] as $recipe) {
            $type = explode(':', $recipe['type'], 2);
            $handler = RecipeHandler::getHandlerForType($type[0], $type[1]);
            if (class_exists($handler)) {
                $content .= '<div class="gui-border">' . $handler::getMarkup($recipe) . '</div>';
            } else {
                $cloner = new VarCloner();
                $dumper = new HtmlDumper();

                $dumper->dump(
                    $cloner->cloneVar($recipe),
                    function ($line, $depth) use (&$content) {
                        if ($depth >= 0) $content .= str_repeat('  ', $depth).$line."\n";
                    }
                );
            }
        }
        return $content;
    }

}
