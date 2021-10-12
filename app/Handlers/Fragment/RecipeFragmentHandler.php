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
        if (count($fragment['recipes']) < 1) return 'No recipes.';
        $content = '';
        foreach ($fragment['recipes'] as $recipe) {
            $type = explode(':', $recipe['type'], 2);
            $handler = RecipeHandler::getHandlerForType($type[0], $type[1]);
            if (class_exists($handler)) {
                $tab = $handler::getTabMarkup($recipe);
                $tab = $tab ? ('<div class="gui-tab">' . $tab . '</div>') : '';
                $markup = $handler::getMarkup($recipe);
                $content .= '<div class="my-2 gui' . (($fragment['obsolete'] ?? false) ? ' gui-transparent' : '') . ' md:justify-start justify-center items-center flex-wrap md:flex-nowrap"><div class="flex">' . $tab . '<div class="gui-border w-max">' . $markup . '</div></div>';
                $note = $fragment['note'] ?? null;
                if ($note) {
                    FragmentHandler::render($note, fn(string $content) => '<p class="wiki-recipe-note">' . $content . '</p>');
                }
                $content .= '</div>';
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

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div>' . $content . '</div>';
    }

}
