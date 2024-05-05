<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBureauVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libel');
            $table->integer('objectif');
            $table->integer('seuil');
            $table->unsignedBigInteger('lieu_vote_id');

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
        Schema::dropIfExists('bureau_votes');
    }
}
