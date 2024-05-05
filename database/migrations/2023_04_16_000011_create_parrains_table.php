<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parrains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom_pren_par');
            $table->string('telephone_par');
            $table->string('nom');
            $table->string('prenom');
            $table->enum('cart_milit', ['Oui', 'Non', 'Sympatisant']);
            $table->string('list_elect');
            $table->string('cart_elect');
            $table->string('telephone');
            $table->date('date_naiss');
            $table->string('code_lv');
            $table->string('residence');
            $table->string('profession');
            $table->text('observation');

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
        Schema::dropIfExists('parrains');
    }
}
