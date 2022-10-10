<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreparatoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preparatoires', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('email')->nullable();
            $table->string('niveau')->nullable();
            $table->string('serie')->nullable();
            $table->string('adresse')->nullable();
            $table->string('genre')->nullable();
            $table->string('prenom')->nullable();
            $table->bigInteger('contact')->nullable();
            $table->string('profile',255)->default('images/default.png')->nullable();
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
        Schema::dropIfExists('preparatoires');
    }
}
