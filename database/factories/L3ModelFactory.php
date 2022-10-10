<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class L3ModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'annee' => $this->faker->randomElement([2022, 2021]),
            'candidat_id' =>$this->faker->unique()->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'groupe' => $this->faker->randomElement(['IDEV','RSI']),
        ];
    }
}
