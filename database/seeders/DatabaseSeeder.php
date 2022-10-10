<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Preparatoire::factory(50)->create();
        \App\Models\Candidat::factory(50)->create();
        // \App\Models\L1Model::factory(50)->create();
        // \App\Models\L2Model::factory(10)->create();
        // \App\Models\L3Model::factory(10)->create();
        // \App\Models\M1Model::factory(10)->create();
        // \App\Models\M2Model::factory(10)->create();
    }
}
