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

    public function getPrecioSFAttribute(){
        return $this->attributes['precio'];
    }

    public function getModeloAttribute(){
        $atributos = $this->attributes['atributos'];
        if($atributos){
            $atributosArray = json_decode($atributos);
            if(array_key_exists("N.° de modelo",$atributosArray)){
                return $atributosArray->{'N.° de modelo'};
            }
        }
        return "";
    }

    public function getAtributosStrAttribute(){
        $atributos = $this->attributes['atributos'];
        if($atributos){
            $atributosArray = json_decode($atributos);
            $regreso = "";
            foreach($atributosArray as $nomAtributo=>$valAtributo){
                if($nomAtributo == "N.° de modelo"){
                    continue;
                }
                $regreso .= $nomAtributo.":".$valAtributo;
                $regreso .= "\n";
            }
            return $regreso;
        }
        return "";
    }

    public function fotos(){
        return $this->hasMany('App\FotosProducto','idproducto','idproductos');
    }

    public function nombresFotos(){
        return $this->hasMany('App\FotosProducto','idproducto','idproductos')->select(['nombre']);
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