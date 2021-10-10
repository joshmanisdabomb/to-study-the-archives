<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

abstract class RefiningRecipeHandler extends RecipeHandler {

    protected static abstract function getIngredientGrid(array $recipe) : array;

    protected static abstract function getIngredientResults(array $recipe) : array;

    protected static abstract function getInputGridWidth(array $recipe): int;

    protected static abstract function getInputGridHeight(array $recipe): int;

    protected static abstract function getOutputGridWidth(array $recipe): int;

    protected static abstract function getOutputGridHeight(array $recipe): int;

    public static function getMarkup(array $recipe) : string {
        return '<div class="gui-recipe">
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getInputGridWidth($recipe), '1fr')) . ';">
                ' . collect(static::getIngredientGrid($recipe))->flatten(1)->map(fn(?Ingredient $ing) => Ingredient::renderSlot($ing))->implode('') . '
            </div>
            <div class="flex flex-col items-center gap-1">
                <div data-mctooltip="' . static::getAction($recipe['translations']) . '" class="gui-refiner-icon gui-refiner-icon-' . static::getIconIndex($recipe) . '"></div>
                <img class="gui-arrow" src="' . asset('images/gui/arrow.png') . '" alt="">
            </div>
            <div class="grid" style="grid-template-columns: ' . implode(' ', array_fill(0, static::getOutputGridWidth($recipe), '1fr')) . ';">
                ' . collect(static::getIngredientResults($recipe))->flatten(1)->map(fn(?Ingredient $ing) => Ingredient::renderSlot($ing))->implode('') . '
            </div>
        </div>
        <div class="gui-recipe-stats mc-text">
            <div><img class="gui-time" src="' . asset('images/gui/time.png') . '" alt="">' . ($recipe['ticks']/20) . 's</div>
            <div><img class="gui-power" src="' . asset('images/gui/power.png') . '" alt="">' . $recipe['energy'] . ' LE/t</div>
        </div>';
    }

    protected static function getIconIndex(array $recipe) {
        return $recipe['icon'];
    }

    protected static function getAction(array $translations) {
        return $translations['action'][App::currentLocale()] ?? $translations['action'][Config::get('fallback_locale')];
    }

}
