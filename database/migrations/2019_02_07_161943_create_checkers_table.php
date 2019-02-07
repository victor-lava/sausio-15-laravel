<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('user_id');
            $table->string('position_name');
            $table->integer('x');
            $table->integer('y');
            $table->boolean('color'); // 0 - white, 1 - black
            $table->boolean('type')->default(1); // 0 - simple, 1 - queen
            $table->boolean('alive')->default(1); // 1 - alive, 0 - dead
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Checkers');
    }
}
