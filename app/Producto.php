<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $primaryKey = 'idproductos';


    public function fotos()
    {
        return $this->hasMany('App\FotosProducto','idproducto','idproductos');
    }
}