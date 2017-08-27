<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootballPredictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_predictions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('prediction_id')->index()->unsigned();
            $table->integer('team_1')->index();
            $table->integer('score_1')->index();
            $table->integer('team_2')->index();
            $table->integer('score_2')->index();
            $table->integer('football_match_id')->index()->unsigned();
            $table->smallInteger('position')->nullable();
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
        Schema::dropIfExists('football_predictions');
    }
}

