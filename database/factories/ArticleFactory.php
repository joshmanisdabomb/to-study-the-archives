<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(2);
        $slug1 = strtolower($this->faker->word());
        $slug2 = strtolower(implode('_', $name));
        return [
            'registry' => strtolower($this->faker->word()) . ':' . $slug1,
            'key' => strtolower($this->faker->word()) . ':' . $slug2,
            'name' => ucwords(implode(' ', $name)),
            'slug1' => $slug1,
            'slug2' => $slug2,
        ];
    }
}
