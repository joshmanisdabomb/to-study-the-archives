<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;

abstract class SpawnerTableRecipeHandler extends GridRecipeHandler {

    protected static function getIngredientResult(array $recipe) : Ingredient {
        return (Ingredient::fromArray($recipe['result']))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    protected static function getGridWidth(array $recipe) : int {
        return 10;
    }

    protected static function getGridHeight(array $recipe) : int {
        return 6;
    }

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getGridWidth($recipe), '1fr')) . ';">' . collect(static::getIngredientGrid($recipe))->flatten(1)->map(function (?Ingredient $ing, int $key) {
                if (in_array($key, [0,1,8,9,10,19,40,49,50,51,58,59])) return Ingredient::renderSlot(null, 'gui-slot');
                return Ingredient::renderSlot($ing);
            })->implode('') . '
            </div>
            <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            ' . Ingredient::renderSlot(static::getIngredientResult($recipe), 'gui-large-slot') . '
        </div>';
    }

}
