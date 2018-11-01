<?php

namespace factura\models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table='gastos';
    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'id_factura',
        'concepto',
        'id_productos',
        'nombre_producto',
        'precio_prducto',
        'cantidad',
        'precio_total_producto',
    ];
    
    protected $guarded =[
    ];
}
