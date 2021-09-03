<?php

namespace Database\Factories;

use App\Models\VersionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VersionGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(4);
        return [
            'name' => ucfirst(implode(' ', $title)),
            'code' => str_replace(' ', '', ucfirst(implode(' ', $title))),
            'branch' => $this->faker->word(),
            'sources' => $this->faker->boolean(),
            'tags' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 10000),
        ];
    }
}
