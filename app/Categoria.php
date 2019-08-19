<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $primaryKey = 'idcategorias';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function subCategorias(){
        return $this->hasMany('App\Categoria','idcategoriapadre','idcategorias');
    }

    public function padre(){
        return $this->belongsTo('App\Categoria', 'idcategoriapadre', 'idcategorias');
    }
}
