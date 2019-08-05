<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $primaryKey = 'idproductos';

    public function getPrecioAttribute(){
        $moneda = number_format( $this->attributes['precio'], 2, '.', ',');
        return $moneda;
    }

    public function fotos(){
        return $this->hasMany('App\FotosProducto','idproducto','idproductos');
    }

    public function foto(){
        return $this->hasOne('App\FotosProducto','idproducto','idproductos');
    }

    public function marca(){
        return $this->hasOne('App\Marca', 'idmarcas', 'idmarca');
    }

    public function categoria(){
        return $this->hasOne('App\Categoria', 'idcategorias', 'idcategoria');
    }
}