<?php

use Illuminate\Database\Seeder;
use factura\models\Producto;
use Illuminate\Support\Facades\DB;
class ProductosSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            'nombre' => str_random(10),
            'precio_unitario' => str_random(10)
        ]);
    }
}
