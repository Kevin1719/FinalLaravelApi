<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom'  =>  $this->faker->lastName() ,
            'prenom' => $this->faker->firstName() ,
            'serie' => $this->faker->randomElement(['A', 'C', 'D']),
            'nationalite' => $this->faker->randomElement(['Malagasy', 'Francais', 'Commoriens']) ,
            'situationFamiliale' => "Celibataire",
            'contact' => $this->faker->e164PhoneNumber() ,
            'adresse' => $this->faker->state(),
            'email' => $this->faker->unique()->safeEmail(),
            'dateDeNaissance' => $this->faker->dateTimeThisCentury($max = 'now', $timezone = null) ,
            'lieuDeNaissance' => $this->faker->state() ,
            'postule' => $this->faker->randomElement(['L1', 'L2', 'L3', 'M1', 'M2']) ,
            'genre' => $this->faker->randomElement(['G', 'F']) ,
            'nomPere'=> $this->faker->name('male'),
            'nomMere'=> $this->faker->name('female'),
            'nomTuteur'=> $this->faker->name(),
            'professionPere'=> $this->faker->jobTitle(),
            'professionMere'=> $this->faker->jobTitle(),
            'professionTuteur'=> $this->faker->jobTitle(),
            'telPere'=> $this->faker->e164PhoneNumber(),
            'telMere'=> $this->faker->e164PhoneNumber(),
            'telTuteur'=> $this->faker->e164PhoneNumber(),
            'anneeCandidature' => date('Y') + 1,
        ];
    }
}
