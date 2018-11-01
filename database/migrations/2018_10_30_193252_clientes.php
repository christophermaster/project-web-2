<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');//identificador de la tabla
            $table->string('nombre'); //nombre de la Escuela de la universidad de carabobo;
            $table->string('apellido'); //nombre de la Escuela de la universidad de carabobo
            $table->string('cedula'); //nombre de la Escuela de la universidad de carabob
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('clientes');
    }
}
