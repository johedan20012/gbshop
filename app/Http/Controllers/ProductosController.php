<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Categoria;
use App\FotosProducto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    private function getBreadcrumb($id,$showLast = false){
        $breadcrumb = null;
   
        $categoria = Categoria::find($id);
        if($categoria != null){
            $padre = $categoria->padre;

            $lastRuta = ($showLast)? route('catalogo').'?id='.$categoria->idcategorias: "";
            if($padre != null){
                $breadcrumb = array(['nombre' => $padre->nombre,'ruta' => route('catalogo').'?id='.$padre->idcategorias ],['nombre' => $categoria->nombre, 'ruta' => $lastRuta ]);
            }else{
                $breadcrumb = array(['nombre' => $categoria->nombre, 'ruta' => $lastRuta]);
            }
        }

        return $breadcrumb;
    }
    /**
     * Muestra todos los productos
     *
     * @return Productos
     */
    public function getCatalogoPorCategoria(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'nullable|integer|digits_between:1,10'
        ]);
        if($request->input('id') !== null){
            $id = $request->input('id');
        }else{
            $id=0;
        }
        $breadcrumb = null;
        if($id == 0){
            $productos = Producto::paginate(5)
            ->setPageName("p");
        }else{
            $productos = Producto::whereIn('idcategoria',function($query2) use ($id){
                            $query2->select('idcategorias')->from('categorias')->where('idcategoriapadre',$id);
                        })->orWhere('idcategoria',$id)
                        ->paginate(5)
                        ->setPageName("p");
            
            $breadcrumb = $this->getBreadcrumb($id);
        }
        /*return view('widgets.tablaProductos', ['productos' => $productos]);

        $productos = Producto::paginate(5)->setPageName("p");*/

        if($request->ajax()){
            $tabla = view('widgets.tablaProductos', ['productos' => $productos,'idcategoria'=>$id])->render();
            $bread = view('widgets.breadcrumb', ['breadcrumb' => $breadcrumb])->render();
            return response()->json(array('tabla' => $tabla, 'bread'=>$bread));
        }

        return view('catalogo', ['productos' => $productos /*Producto::all()*/, 'categorias' => Categoria::all()->where('idcategoriapadre',null), 'breadcrumb' => $breadcrumb,'idcategoria'=>$id]);
    }

    /**
     * Muestra todos los productos por categoria, si la categoria es 0 regresa todos los productos
     *
     * @return Productos
     */

    public function getInicio(Request $request){
        $productos = Producto::all()->take(4);
        return view('inicio', ['productos'=>$productos,'categorias' => Categoria::all()->where('idcategoriapadre',null)]);
    }

    public function getProducto(Request $request){
        $validatedData = $request->validate([
            'code' => 'nullable|string'
        ]);


        if($request->input('code') !== null){
            $codigo = $request->input('code');

            $producto = Producto::where('codigo',$codigo)->first();

            if($producto == null){
                return view('extras.error')->withErrors(["error" => "Producto inexistente"]);
            }
        }else{
            return view('extras.error')->withErrors(["error" => "Producto inexistente"]);
        }
        
        $breadcrumb = $this->getBreadcrumb($producto->idcategoria,true);

        return view('producto', ['producto' => $producto,'breadcrumb'=>$breadcrumb]);
    }
}