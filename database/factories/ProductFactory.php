<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            'name' => $this->faker->firstNameMale, 
            'price' => $this->faker->numberBetween(1000,1200),
            'quantity' => $this->faker->numberBetween(1000,1200),
            'description' => $this->faker->text(200),
            'image' => $this->faker->imageUrl(500, 500, true),

        ];
    }
}
