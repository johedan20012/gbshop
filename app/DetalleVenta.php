<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'iddetalleVentas';

    public function producto(){
        return $this->hasOne('App\Producto', 'idproductos', 'idproducto');
    }
}
