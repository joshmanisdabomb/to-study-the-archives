<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;

class RefiningShapelessRecipeHandler extends RefiningRecipeHandler {

    protected static function getIngredientGrid(array $recipe) : array {
        return static::getShapelessIngredients($recipe['ingredients'], static::getInputGridWidth($recipe), static::getInputGridHeight($recipe), $recipe['translations']);
    }

    protected static function getIngredientResults(array $recipe) : array {
        return static::getShapelessIngredients($recipe['results'], static::getInputGridWidth($recipe), static::getInputGridHeight($recipe), $recipe['translations']);
    }

    protected static function getInputGridWidth(array $recipe) : int {
        return 3;
    }

    protected static function getInputGridHeight(array $recipe) : int {
        return 2;
    }

    protected static function getOutputGridWidth(array $recipe) : int {
        return 3;
    }

    protected static function getOutputGridHeight(array $recipe) : int {
        return 2;
    }

}
