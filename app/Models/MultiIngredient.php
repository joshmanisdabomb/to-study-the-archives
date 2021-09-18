<?php

namespace App\Models;

class MultiIngredient extends Ingredient {

    private array $ingredients;

    /**
     * MultiIngredient constructor.
     * @param \App\Models\Ingredient[] $ingredients
     */
    public function __construct(array $ingredients = []) {
        parent::__construct($ingredients[0]->toArray());
        $this->ingredients = $ingredients;
    }

    public function setNameFrom(array $translations) : Ingredient {
        collect($this->ingredients)->each(fn(Ingredient $ing) => $ing->setNameFrom($translations));
        return $this;
    }

    public function insideSlot() : string {
        return collect($this->ingredients)->map(fn(Ingredient $ing, int $key) => '<div class="gui-slot-entry" style="display: ' . ($key == 0 ? 'block' : 'none') . ';">' . $ing->insideSlot() . '</div>')->implode('');
    }

}
