<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_messages', function (Blueprint $table) {
            $table->id();
            $table->string("lieuvote")->nullable();
            $table->longText("message")->nullable();
            $table->unsignedInteger("from")->default(0);
            $table->unsignedInteger("to")->default(0);
            $table->boolean("dejalu")->default(false);
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
        Schema::dropIfExists('agent_messages');
    }
}
