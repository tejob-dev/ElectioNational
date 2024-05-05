<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesVerbalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proces_verbals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libel')->nullable();
            $table->string('photo');
            $table->unsignedBigInteger('bureau_vote_id');

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
        Schema::dropIfExists('proces_verbals');
    }
}
