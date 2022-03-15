<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;

class SpawnerTableShapelessRecipeHandler extends SpawnerTableRecipeHandler {

    protected static function getIngredientGrid(array $recipe) : array {
        $ingredients = static::getShapelessIngredients($recipe['ingredients'], static::getGridWidth($recipe), static::getGridHeight($recipe), $recipe['tags'], $recipe['translations'], $recipe['links']);
        //TODO array_splice($ingredients)
        return $ingredients;
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'lcc:spawner_table', 'name' => ['text' => __("wiki.recipe." . SpawnerTableShapelessRecipeHandler::type())]]), 'gui-slot');
    }

}
