<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

abstract class StonecuttingRecipeHandler extends RecipeHandler {

    protected static function getIngredientInput(array $recipe) : Ingredient {
        return (Ingredient::fromArray($recipe['ingredient']))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    protected static function getIngredientResult(array $recipe) : Ingredient {
        return (new Ingredient(['item' => $recipe['result'], 'count' => $recipe['count']]))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            ' . Ingredient::renderSlot(static::getIngredientInput($recipe)) . '
            <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            ' . Ingredient::renderSlot(static::getIngredientResult($recipe), 'gui-large-slot') . '
        </div>';
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'minecraft:stonecutter', 'translation' => __("wiki.recipe." . StonecuttingRecipeHandler::type())]), 'gui-slot');
    }

}
