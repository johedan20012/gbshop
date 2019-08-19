<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Marca;
use App\Categoria;

use Validator;

class AdminController extends Controller
{
    public function getPanel(Request $request,$numPag = null){

        if($request->ajax()){

            if($request->has('cadena')){
                //Buscar marcas por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $marcas = Marca::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->paginate(10)->setPageName("p");
            
                    $tabla = view('widgets.tablaMarcas', ['marcas1' => $marcas,'actual' => $request->input('cadena')])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }else{
                    $marcas = Marca::paginate(10)->setPageName("p");
            
                    $tabla = view('widgets.tablaMarcas', ['marcas1' => $marcas])->render();

                    return response()->json(array('tabla' => $tabla));
                }
            }
            
            //Traer marcas indiscriminadamente
            
            $marcas = Marca::paginate(10)->setPageName("p");
            
            $tabla = view('widgets.tablaMarcas', ['marcas1' => $marcas])->render();

            return response()->json(array('tabla' => $tabla));
        }

        $marcas = Marca::orderBy('nombre')->get();
        $marcas1 = Marca::orderBy('nombre')->paginate(10)->setPageName("p");
        $categorias = Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get();

        //$productos = Producto::paginate(5)->setPageName("p");

        return view('auth.admin', [
            'marcas' => $marcas, 
            'marcas1'=> $marcas1, 
            'categorias' => $categorias,
            'numPag' => $numPag //Como numPag solo es enviado atraves del servidor , no lo valido
        ]);
    }

    public function getSubCategorias(Request $request){

        $validacion = Validator::make($request->all(), array(
            'id' => 'required|integer'
        ));

        if($validacion->fails()){
            return "";
        }
        
        return Categoria::where('idcategoriapadre',$request->input('id'))->orderBy('nombre')->get();
    }

    public function storeMarca(Request $request){
        $validacion = Validator::make($request->all(), array(
            'marca-nombre' => 'required|string|max:50'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['numPag' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca, revisa el campo');
        }

        $marca = new Marca();
        
        $marca->nombre = $request->input('marca-nombre');
        try{
            if(!$marca->save()){ //No se logro guardar la marca de manera correcta;
                return redirect()->route('admin',['numPag' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['numPag' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca');
        }

        return redirect()->route('admin',['numPag' => 2])->with('Mensaje' , 'Marca registrada con exito!');
    }

    public function storeCategoria(Request $request){
        
        $validacion = Validator::make($request->all(), array(
            'categoria-nombre' => 'required|string|max:50',
            'categoria-padre' => 'nullable|integer'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['numPag' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria, revisa los campos');
        }

        $categoria = new Categoria();
        
        $categoria->nombre = $request->input('categoria-nombre');
        $categoria->idcategoriapadre = $request->input('categoria-padre');
        try{
            if(!$categoria->save()){ //No se logro guardar la categoria de manera correcta;
                return redirect()->route('admin',['numPag' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['numPag' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria');
        }

        return redirect()->route('admin',['numPag' => 3])->with('Mensaje' , 'Categoria registrada con exito!');
    }
}
