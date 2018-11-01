<?php

namespace factura\models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table='productos';
    protected $primaryKey='id';

    public $timestamps=false;


    protected $fillable =[
        'nombre',
        'precio_unitario',
    ];
    
    protected $guarded =[
    ];
}
