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
            $table->integer('event_id')->unsigned();
            $table->integer('team_1')->index();
            $table->integer('score_1')->index();
            $table->integer('team_2')->index();
            $table->integer('score_2')->index();
            $table->smallInteger('type')->default(1);
            $table->integer('same_respondent_number')->index();
            $table->date('date')->nullable();
            $table->date('position')->nullable();
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
