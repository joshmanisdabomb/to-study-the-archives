<?php

namespace App\Handlers\Fragment;

use App\Handlers\Recipe\RecipeHandler;
use App\Models\Article;
use App\Models\ArticleFragment;
use RuntimeException;

class RecipeFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['recipes'] as $recipe) {
            $type = explode(':', $recipe['type'], 2);
            $handler = RecipeHandler::getHandlerForType($type[0], $type[1]);
            $content .= '<div class="gui-border">' . $handler::getMarkup($recipe) . '</div>';
        }
        return $content;
    }

}
