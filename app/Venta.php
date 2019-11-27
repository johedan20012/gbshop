<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $primaryKey = 'idventas';

    public function detalles(){
        return $this->hasMany('App\DetalleVenta','idventa','idventas');
    }

    public function usuario(){
        return $this->hasOne('App\Cliente','idclientes','idcliente');
    }
}
