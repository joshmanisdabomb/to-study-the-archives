<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;

abstract class GridRecipeHandler extends RecipeHandler {

    protected static abstract function getIngredientGrid(array $recipe) : array;

    protected static abstract function getIngredientResult(array $recipe) : Ingredient;

    protected static abstract function getGridWidth(array $recipe): int;

    protected static abstract function getGridHeight(array $recipe): int;

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getGridHeight($recipe), '1fr')) . ';">
                ' . collect(static::getIngredientGrid($recipe))->flatten(1)->map(fn(?Ingredient $ing) => Ingredient::renderSlot($ing))->implode('') . '
            </div>
            <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            ' . Ingredient::renderSlot(static::getIngredientResult($recipe), 'gui-large-slot') . '
        </div>';
    }

}
