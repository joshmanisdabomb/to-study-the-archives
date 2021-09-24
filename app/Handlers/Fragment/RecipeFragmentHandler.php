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
        if (count($fragment['recipes']) < 1) return 'No recipes.';
        foreach ($fragment['recipes'] as $recipe) {
            $type = explode(':', $recipe['type'], 2);
            $handler = RecipeHandler::getHandlerForType($type[0], $type[1]);
            if (class_exists($handler)) {
                $tab = $handler::getTabMarkup($recipe);
                $tab = $tab ? ('<div class="gui-tab">' . $tab . '</div>') : '';
                $markup = $handler::getMarkup($recipe);
                $content .= '<div class="gui' . (($fragment['obsolete'] ?? false) ? ' gui-transparent' : '') . ' md:justify-start justify-center">' . $tab . '<div class="gui-border">' . $markup . '</div>';
                $note = $fragment['note'] ?? null;
                if ($note) {
                    $handler = FragmentHandler::getHandlerForType($note['fragment']);
                    if (class_exists($handler)) {
                        $content .= '<p class="wiki-recipe-note">' . $handler::getMarkup($note) . '</p>';
                    } else {
                        $cloner = new VarCloner();
                        $dumper = new HtmlDumper();

                        $dumper->dump(
                            $cloner->cloneVar($note),
                            function ($line, $depth) use (&$content) {
                                if ($depth >= 0) $content .= str_repeat('  ', $depth).$line."\n";
                            }
                        );
                    }
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

}
