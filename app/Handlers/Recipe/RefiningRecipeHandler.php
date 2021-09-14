<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Str;

abstract class RefiningRecipeHandler extends RecipeHandler {

    protected static abstract function getIngredientGrid(array $recipe) : array;

    protected static abstract function getIngredientResults(array $recipe) : array;

    protected static abstract function getInputGridWidth(array $recipe): int;

    protected static abstract function getInputGridHeight(array $recipe): int;

    protected static abstract function getOutputGridWidth(array $recipe): int;

    protected static abstract function getOutputGridHeight(array $recipe): int;

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getInputGridWidth($recipe), RecipeHandler::SLOT_WIDTH)) . ';">
                ' . collect(static::getIngredientGrid($recipe))->flatten(1)->map(fn(?Ingredient $ing) => static::renderSlot($ing))->implode('') . '
            </div>
            <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getOutputGridWidth($recipe), RecipeHandler::SLOT_WIDTH)) . ';">
                ' . collect(static::getIngredientResults($recipe))->flatten(1)->map(fn(?Ingredient $ing) => static::renderSlot($ing))->implode('') . '
            </div>
        </div>';
    }

}
