<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PreparatoireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastname(),
            'prenom' => $this->faker->firstname(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => $this->faker->e164PhoneNumber(),
            'serie' => $this->faker->randomElement(['c','a','d']),
            'niveau' => $this ->faker->randomElement(['L1','L2','L3','M1','M2']),
            'adresse' => $this ->faker -> state(),
            'genre' => $this -> faker -> randomElement(['G','F']),
            'bordereauDeDonnee' => 'none',
        ];
    }
}
