<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarcasController extends Controller
{
    public function store(Request $request){
        $validacion = Validator::make($request->all(), array(
            'marca-nombre' => 'required|string|max:50'
        ));
        
        if($validacion->fails()){
            return ['exito'=>false,'msg' => 'Validacion de campos','codigo' => 501];
        }

        $marca = new Marca();
        
        $marca->nombre = $request->input('marca-nombre');
        try{
            if(!$marca->save()){ //No se logro guardar la marca de manera correcta;
                return ['exito'=>false,'msg' => 'Error interno','codigo' => 500];
            }
        } catch (\Illuminate\Database\QueryException $e){
            return ['exito'=>false,'msg' => 'Error interno','codigo' => 500];
        }

        return ['exito'=>true,'msg' => '','codigo' => 400];
    }
}
