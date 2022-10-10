<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class L1ModelFactory extends Factory
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
            'candidat_id' =>$this->faker->unique()->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50]),
            'groupe' => $this->faker->randomElement(['G1','G2']),
        ];
    }
}
