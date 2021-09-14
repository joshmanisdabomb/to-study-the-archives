<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;

abstract class RecipeHandler {

    const SLOT_WIDTH = (18 * 4) . 'px';

    public static function getHandlerForType(string $namespace, string $path) : string {
        return '\\App\\Handlers\\Recipe\\' . Str::studly($path) . 'RecipeHandler';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -strlen("RecipeHandler"));
        return Str::snake($shortName);
    }

    public static abstract function getMarkup(array $fragment) : string;

    public static function renderItem(string $namespace, string $path) {
        return '<img src="' . asset('images/models/' . $namespace . '/' . $path . '.png') . '" alt="' . $namespace . ':' . $path . '">';
    }

    public static function getShapedIngredients(array $pattern, array $key, ?int $padWidth, ?int $padHeight, array $translations = []) : array {
        $grid = [];
        foreach ($pattern as $row) {
            $gr = [];
            foreach (str_split($row) as $column) {
                $gr[] = $key[$column] ?? null;
            }
            if ($padWidth == null) {
                $grid += $gr;
            } else {
                $gr = array_pad($gr, $padWidth, null);
                $gr = array_map(function (?array $ing) use ($translations) {
                    if (!$ing) return null;
                    return (new Ingredient($ing))->setNameFrom($translations);
                }, $gr);
                $grid[] = $gr;
            }
        }
        if ($padHeight == null) return $grid;
        return array_pad($grid, $padHeight, array_fill(0, $padWidth, null));
    }

    public static function getShapelessIngredients(array $ingredients, ?int $padWidth, ?int $padHeight, array $translations = []) : array {
        $list = collect($ingredients)->map(fn(array $ing) => (new Ingredient($ing))->setNameFrom($translations))->all();
        if ($padWidth == null && $padHeight == null) return $list;
        $grid = [];
        for ($i = 0; $i < $padHeight; $i++) {
            $grid[] = array_pad(array_slice($list, $padWidth * $i, $padWidth, false), $padWidth, null);
        }
        return $grid;
    }

    public static function getShapelessIngredientsFlat(array $ingredients, ?int $padWidth, ?int $padHeight, array $translations = []) : array {
        $ingredients = static::getShapelessIngredients($ingredients, null, null, $translations);
        $list = collect($ingredients)->flatMap(fn(Ingredient $ing) => array_fill(0, $ing->count ?: 1, $ing))->all();
        if ($padWidth == null && $padHeight == null) return $list;
        $grid = [];
        for ($i = 0; $i < $padHeight; $i++) {
            $grid[] = array_pad(array_slice($list, $padWidth * $i, $padWidth, false), $padWidth, null);
        }
        return $grid;
    }

    public static function renderSlot(?Ingredient $inside, string $class = 'gui-slot') : string {
        return '<div class="' . $class . '">' . ($inside ? $inside->insideSlot() : '') . '</div>';
    }

}
