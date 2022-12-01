<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->domainWord(),
            'description' => $this->faker->realText(),
            'image' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'created_at' => $this->faker->dateTimeBetween('-6 months')
        ];
    }
}
