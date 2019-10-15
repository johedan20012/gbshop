<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $primaryKey = 'idventas';

    public $timestamps = false;

    public function detalles(){
        return $this->hasMany('App\DetalleVenta','idventa','idventas');
    }
}
