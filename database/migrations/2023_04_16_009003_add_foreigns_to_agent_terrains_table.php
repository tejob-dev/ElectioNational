<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToAgentTerrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_terrains', function (Blueprint $table) {
            $table
                ->foreign('lieu_vote_id')
                ->references('id')
                ->on('lieu_votes')
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
        Schema::table('agent_terrains', function (Blueprint $table) {
            $table->dropForeign(['lieu_vote_id']);
        });
    }
}
