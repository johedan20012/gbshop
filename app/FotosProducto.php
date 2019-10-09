<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosProducto extends Model
{
    protected $table = 'fotos_productos';

    protected $primaryKey = 'idfotos_productos';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getIdAttribute(){
        return $this->attributes['idfotos_productos'];
    }
}
