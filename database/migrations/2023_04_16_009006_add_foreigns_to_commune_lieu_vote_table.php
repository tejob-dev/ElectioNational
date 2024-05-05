<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToCommuneLieuVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commune_lieu_vote', function (Blueprint $table) {
            $table
                ->foreign('lieu_vote_id')
                ->references('id')
                ->on('lieu_votes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('commune_id')
                ->references('id')
                ->on('communes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commune_lieu_vote', function (Blueprint $table) {
            $table->dropForeign(['lieu_vote_id']);
            $table->dropForeign(['commune_id']);
        });
    }
}
