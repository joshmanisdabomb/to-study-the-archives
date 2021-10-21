<?php

namespace App\Handlers\Recipe;

use App\Models\Ingredient;
use RuntimeException;

class SpawnerTableShapedRecipeHandler extends SpawnerTableRecipeHandler {

    protected static function getIngredientGrid(array $recipe) : array {
        $pattern = $recipe['pattern'];
        $ph = count($pattern);
        $pw = strlen($pattern[0]);
        for ($i = 0; $i <= static::getGridWidth($recipe) - $pw; $i++) {
            for ($j = 0; $j <= static::getGridHeight($recipe) - $ph; $j++) {
                foreach ($pattern as $line => $row) {
                    $row = str_repeat(' ', $i) . $row;
                    $invRow = $j + $line;
                    switch ($invRow) {
                        case 0:
                        case 5:
                            if (strlen(trim($row)) > 6 || strpos($row, '  ') !== 0) continue 3;
                            break;
                        case 1:
                        case 4:
                            if (strlen(trim($row)) > 8 || strpos($row, ' ') !== 0) continue 3;
                            break;
                        case 2:
                        case 3:
                            break;
                        default:
                            continue 3;
                    }
                }
                return static::getShapedIngredients(array_map(fn(string $row) => str_repeat(' ', $i) . $row, $pattern), $recipe['key'], static::getGridWidth($recipe), static::getGridHeight($recipe), $recipe['tags'], $recipe['translations'], $recipe['links']);
            }
        }
        throw new RuntimeException("Could not fit spawner table recipe into crafting window.");
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'lcc:spawner_table', 'translation' => __("wiki.recipe." . SpawnerTableShapedRecipeHandler::type())]), 'gui-slot');
    }

}
