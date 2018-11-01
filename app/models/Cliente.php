<?php

namespace factura\models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $table='clientes';
    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'apellido',
        'cedula',
    ];
    
    protected $guarded =[
    ];
}
