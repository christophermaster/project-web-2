<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Gastos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->increments('id');//identificador de la tabla
            $table->integer('id_factura')->unsigned(); //nombre de la Escuela de la universidad de carabobo;
            $table->string('concepto'); //nombre de la Escuela de la universidad de carabobo
            $table->integer('id_productos'); //nombre de la Escuela de la universidad de carabobo
            $table->string('nombre_producto'); //nombre de la Escuela de la universidad de carabobo
            $table->string('precio_unitario'); //nombre de la Escuela de la universidad de carabobo
            $table->string('precio_prducto'); //nombre de la Escuela de la universidad de carabobo
            $table->integer('cantidad'); //nombre de la Escuela de la universidad de carabob
            $table->double('precio_total_producto'); //nombre de la Escuela de la universidad de carabob
            $table->double('precio_iva'); //nombre de la Escuela de la universidad de carabob
        });
        Schema::table('gastos', function($table){
            $table->foreign('id_factura')->references('id')->on('facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gastos', function($table)
        {
            Schema::dropIfExists('gastos');
            $table->dropForeign('gastos_id_factura_foreign');

        });
    }
}
