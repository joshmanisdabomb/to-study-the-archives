<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class CraftingShapedRecipeHandler extends GridRecipeHandler {

    protected static function getIngredientGrid(array $recipe) : array {
        return static::getShapedIngredients($recipe['pattern'], $recipe['key'], static::getGridWidth($recipe), static::getGridHeight($recipe), $recipe['translations']);
    }

    protected static function getIngredientResult(array $recipe) : Ingredient {
        return (Ingredient::fromArray($recipe['result']))->setNameFrom($recipe['translations']);
    }

    protected static function getGridWidth(array $recipe) : int {
        return 3;
    }

    protected static function getGridHeight(array $recipe) : int {
        return 3;
    }

}
