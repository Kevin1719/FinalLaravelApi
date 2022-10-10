<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollonesToCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->integer('nbrStage')->nullable();
            $table->string('entrepriseStage')->nullable();
            $table->integer('nbrAlternance')->nullable();
            $table->text('entrepriseAlternance')->nullable();
            $table->longText('travauxPerso')->nullable();
            $table->longText('activiteParaPro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidats', function (Blueprint $table) {
            //
        });
    }
}
