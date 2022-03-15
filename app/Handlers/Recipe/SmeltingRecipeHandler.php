<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

abstract class SmeltingRecipeHandler extends RecipeHandler {

    protected static function getIngredientInput(array $recipe) : Ingredient {
        return (Ingredient::fromArray($recipe['ingredient']))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    protected static function getIngredientResult(array $recipe) : Ingredient {
        return (new Ingredient(['item' => $recipe['result'], 'count' => $recipe['count'] ?? 1]))->setTagFrom($recipe['tags'])->setNameFrom($recipe['translations'])->setLinkFrom($recipe['links']);
    }

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            <div class="grid" style="grid-template-columns: 1fr;">
                ' . Ingredient::renderSlot(static::getIngredientInput($recipe)) . '
                <img class="gui-smelt" src="' . asset('images/gui/burn.png') . '" alt="Fuel" title="Fuel">
            </div>
            <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            ' . Ingredient::renderSlot(static::getIngredientResult($recipe), 'gui-large-slot') . '
        </div>
        <div class="gui-recipe-stats mc-text">
            <div><img class="gui-time" src="' . asset('images/gui/time.png') . '" alt="">' . ($recipe['cookingtime']/20) . 's</div>
            <div><img class="gui-experience" src="' . asset('images/gui/experience.png') . '" alt="">' . $recipe['experience'] . ' XP</div>
        </div>';
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'minecraft:furnace', 'name' => ['text' => __("wiki.recipe." . SmeltingRecipeHandler::type())]]), 'gui-slot');
    }

}
