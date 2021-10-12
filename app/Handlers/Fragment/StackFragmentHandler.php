<?php

namespace App\Handlers\Fragment;

use App\Models\Ingredient;

class StackFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        return '<div class="gui-stacks">' . collect($fragment['stacks'])->map(fn(array $stack) => Ingredient::renderSlot((Ingredient::fromArray($stack))->setNameFrom($fragment['translations'])->setLinkFrom($fragment['links'])))->implode('') . '</div>';
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div class="my-2">' . $content . '</div>';
    }

}
