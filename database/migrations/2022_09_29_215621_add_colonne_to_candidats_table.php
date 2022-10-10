<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColonneToCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function (Blueprint $table) {

            $table->string('selectedReleveDeNoteBacc')->nullable();
            $table->string('selectedReleveDeNoteSeconde')->nullable();
            $table->string('selectedReleveDeNotePremiere')->nullable();
            $table->string('selectedReleveDeNoteTerminale')->nullable();
            $table->string('certificatDeResidance')->nullable();
            $table->string('selectedPhoto')->nullable();
            $table->string('selectedCINorCIS')->nullable();
            $table->string('cv')->nullable();
            $table->string('bordereauEsti')->nullable();
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
