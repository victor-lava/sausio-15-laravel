<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('first_user_id')->nullable();
            $table->unsignedInteger('second_user_id')->nullable();
            $table->string('hash');
            $table->datetime('started_at')->nullable(); // pakeisit į datetimestamp, imti lentos sukūrimo momentą ir lyginti su dabartniu laiku ir taip išskaičiuoti trukmę
            $table->boolean('status')->default(0); // 0 - waiting, 1 - ongoing, 2 - completed
            $table->timestamps();

            $table->foreign('first_user_id')->references('id')->on('users');

            $table->foreign('second_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Games');
    }
}
