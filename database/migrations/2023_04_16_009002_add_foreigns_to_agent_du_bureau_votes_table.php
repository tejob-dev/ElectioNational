<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToAgentDuBureauVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_du_bureau_votes', function (Blueprint $table) {
            $table
                ->foreign('bureau_vote_id')
                ->references('id')
                ->on('bureau_votes')
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
        Schema::table('agent_du_bureau_votes', function (Blueprint $table) {
            $table->dropForeign(['bureau_vote_id']);
        });
    }
}
