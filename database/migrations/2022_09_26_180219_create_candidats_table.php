<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('serie')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('situationFamiliale')->nullable();
            $table->bigInteger('contact')->nullable();
            $table->integer('nombreEnfant')->default(0)->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('dateDeNaissance')->nullable();
            $table->string('lieuDeNaissance')->nullable();
            $table->string('postule')->nullable();
            $table->string('genre', 1)->nullable();
            $table->boolean('concours')->nullable();
            $table->boolean('entretien')->nullable();
            $table->string('status')->nullable();
            $table->integer('anneeCandidature')->nullable();
            $table->string('matricule')->nullable();
            $table->string('nomPere')->nullable();
            $table->string('nomMere')->nullable();
            $table->string('nomTuteur')->nullable();
            $table->string('professionPere')->nullable();
            $table->string('professionMere')->nullable();
            $table->string('professionTuteur')->nullable();
            $table->string('telPere')->nullable();
            $table->string('telMere')->nullable();
            $table->string('telTuteur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}
