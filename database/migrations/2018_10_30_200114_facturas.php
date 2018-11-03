<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Facturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');//identificador de la tabla
            $table->integer('id_cliente')->unsigned(); //nombre de la Escuela de la universidad de carabobo;
            $table->double('total'); //nombre de la Escuela de la universidad de carabobo
            $table->double('total_impuesto'); //nombre de la Escuela de la universidad de carabobo
            $table->double('sub_total'); //nombre de la Escuela de la universidad de carabobo
            $table->string('hora'); //nombre de la Escuela de la universidad de carabob
            $table->string('fecha_creacion'); //nombre de la Escuela de la universidad de carabob
            $table->string('fecha_modificacion'); //nombre de la Escuela de la universidad de carabob
            $table->boolean('impresa'); //nombre de la Escuela de la universidad de carabob
            $table->boolean('Anular');
        });
        Schema::table('facturas', function($table){
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function($table)
        {
            Schema::dropIfExists('facturas');
            $table->dropForeign('facturas_id_cliente_foreign');

        });
    }
}
