<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToLieuVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lieu_votes', function (Blueprint $table) {
            $table
                ->foreign('quartier_id')
                ->references('id')
                ->on('quartiers')
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
        Schema::table('lieu_votes', function (Blueprint $table) {
            $table->dropForeign(['quartier_id']);
        });
    }
}
