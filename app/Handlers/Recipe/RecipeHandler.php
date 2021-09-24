<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use Illuminate\Support\Str;
use Jenssegers\Model\Model;

abstract class RecipeHandler {

    const SLOT_WIDTH = (18 * 3) . 'px';

    public static function getHandlerForType(string $namespace, string $path) : string {
        return '\\App\\Handlers\\Recipe\\' . Str::studly($path) . 'RecipeHandler';
    }

    public static function type() : string {
        $shortName = substr((new \ReflectionClass(static::class))->getShortName(), 0, -strlen("RecipeHandler"));
        return Str::snake($shortName);
    }

    public static abstract function getMarkup(array $fragment) : string;

    public static abstract function getTabMarkup(array $fragment) : ?string;

    public static function getShapedIngredients(array $pattern, array $key, ?int $padWidth, ?int $padHeight, array $tags = [], array $translations = [], array $links = []) : array {
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
                $gr = array_map(function (?array $ing) use ($translations, $links, $tags) {
                    if (!$ing) return null;
                    return (Ingredient::fromArray($ing))->setTagFrom($tags)->setNameFrom($translations)->setLinkFrom($links);
                }, $gr);
                $grid[] = $gr;
            }
        }
        if ($padHeight == null) return $grid;
        return array_pad($grid, $padHeight, array_fill(0, $padWidth, null));
    }

    public static function getShapelessIngredients(array $ingredients, ?int $padWidth, ?int $padHeight, array $tags = [], array $translations = [], array $links = []) : array {
        $list = collect($ingredients)->map(fn(array $ing) => (Ingredient::fromArray($ing))->setTagFrom($tags)->setNameFrom($translations)->setLinkFrom($links))->all();
        if ($padWidth == null && $padHeight == null) return $list;
        $grid = [];
        for ($i = 0; $i < $padHeight; $i++) {
            $grid[] = array_pad(array_slice($list, $padWidth * $i, $padWidth, false), $padWidth, null);
        }
        return $grid;
    }

    public static function getShapelessIngredientsFlat(array $ingredients, ?int $padWidth, ?int $padHeight, array $tags = [], array $translations = [], array $links = []) : array {
        $ingredients = static::getShapelessIngredients($ingredients, null, null, $tags, $translations, $links);
        $list = collect($ingredients)->flatMap(fn(Ingredient $ing) => array_fill(0, $ing->count ?: 1, $ing))->all();
        if ($padWidth == null && $padHeight == null) return $list;
        $grid = [];
        for ($i = 0; $i < $padHeight; $i++) {
            $grid[] = array_pad(array_slice($list, $padWidth * $i, $padWidth, false), $padWidth, null);
        }
        return $grid;
    }

    public static function renderSlot(?Ingredient $inside, string $class = 'gui-slot gui-slot-back') : string {
        return '<div class="' . $class . '">' . ($inside ? $inside->insideSlot() : '') . '</div>';
    }

}
