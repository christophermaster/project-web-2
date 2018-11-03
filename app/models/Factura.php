<?php

namespace factura\models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table='facturas';
    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'id_cliente',
        'total',
        'total_impuesto',
        'sub_total',
        'hora',
        'fecha_creacion',
        'fecha_modificacion',
        'impresa',
        'Anular'
    ];
    
    protected $guarded =[
    ];
}
