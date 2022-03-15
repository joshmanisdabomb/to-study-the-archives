<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;

class CraftingShapedRecipeHandler extends GridRecipeHandler {

    protected static function getIngredientGrid(array $recipe) : array {
        return static::getShapedIngredients($recipe['pattern'], $recipe['key'], static::getGridWidth($recipe), static::getGridHeight($recipe), $recipe['tags'], $recipe['translations'], $recipe['links']);
    }

    protected static function getIngredientResult(array $recipe) : Ingredient {
        return (Ingredient::fromArray($recipe['result']))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    protected static function getGridWidth(array $recipe) : int {
        return 3;
    }

    protected static function getGridHeight(array $recipe) : int {
        return 3;
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'minecraft:crafting_table', 'name' => ['text' => __("wiki.recipe." . CraftingShapedRecipeHandler::type())]]), 'gui-slot');
    }

}
