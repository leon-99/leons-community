<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(rand(10, 30)),
            'body' => $this->faker->realText(rand(100, 300)),
            'category_id' => rand(1, 5),
            "user_id" => rand(1, 10)
        ];
    }
}
