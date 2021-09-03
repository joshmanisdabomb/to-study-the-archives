<?php

namespace Database\Factories;

use App\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Version::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modver = $this->faker->numberBetween(0, 9) . '.' . $this->faker->numberBetween(0, 9) . '.' . $this->faker->numberBetween(0, 9);
        return [
            'mod_version' => $modver,
            'mc_version' => $this->faker->numberBetween(19, 23) . 'w' . str_pad($this->faker->numberBetween(1, 52), 2, '0', STR_PAD_LEFT) . 'a',
            'name' => $modver,
            'group_id' => $this->faker->numberBetween(1, 4),
            'title' => ucfirst(implode(' ', $this->faker->words(4))),
            'changelog' => $this->faker->paragraphs(),
            'order' => $this->faker->numberBetween(0, 10000),
            'released_at' => Carbon::now()->subSeconds($this->faker->numberBetween(0, 10000000)),
        ];
    }
}
