<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Categoria;
use App\Producto;

class ProductosController extends Controller
{
    /**
     * Regresa la ventana principal de la tienda con 4 productos al azar
     *
     * @return view(INICIO)
     */

    public function getInicio(Request $request){
        $productos = Producto::take(4)->get();
        return view('inicio', ['productos'=>$productos,'conSideBar'=>true,'categorias' => Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get()]);
    }

     /**
     * Muestra el catalogo de productos dependiendo la categoria
     *
     * @return Productos
     */
    public function getCatalogoPorCategoria(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'nullable|integer|digits_between:1,10',
            'cadena' => 'nullable|string|max:50'
        ]);
        $id = ($request->input('id') !== null)? $request->input('id') : 0;
        $cadena = ($request->input('cadena') !== null)? $request->input('cadena') : "";

        $breadcrumb = null;
        if($cadena != ""){
            $productos = Producto::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('nombre')->paginate(20)->setPageName("p");
            //return view('catalogo', ['productos' => $productos, 'categorias' => Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get(), 'breadcrumb' => $breadcrumb]);
        }else{

            if($id == 0){
                $productos = Producto::orderBy('nombre')->paginate(20)->setPageName("p");
            }else{
                $productos = Producto::whereIn('idcategoria',function($query2) use ($id){
                                $query2->select('idcategorias')->from('categorias')->where('idcategoriapadre',$id);
                            })->orWhere('idcategoria',$id)->orderBy('nombre')
                            ->paginate(20)
                            ->setPageName("p");
                
                $breadcrumb = $this->getBreadcrumb($id);
            }

        }
        /*return view('widgets.tablaProductos', ['productos' => $productos]);

        $productos = Producto::paginate(5)->setPageName("p");*/

        if($request->ajax()){
            $tabla = view('widgets.tablaProductos', ['productos' => $productos,'actual' => $id,'actual2' => $cadena])->render();
            $bread = view('widgets.breadcrumb', ['breadcrumb' => $breadcrumb])->render();
            return response()->json(array('tabla' => $tabla, 'bread'=>$bread));
        }

        return view('catalogo', ['productos' => $productos, 'categorias' => Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get(), 'breadcrumb' => $breadcrumb,'actual' => $id,'actual2' => $cadena]);
    }

    /**
     * Muestra el producto al que le pertenece el codigo enviado como 'code'
     *
     * @return Producto
     */
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
}
