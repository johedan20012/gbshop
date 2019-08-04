<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Categoria;
use App\FotosProducto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Muestra todos los productos
     *
     * @return Productos
     */
    public function getCatalogo(Request $request)
    {
        $productos = Producto::paginate(5)->setPageName("p");

        if($request->ajax()){
            return view('tablaProductos', ['productos' => $productos]);
        }

        return view('catalogo', ['productos' => $productos /*Producto::all()*/, 'categorias' => Categoria::all()->where('idcategoriapadre',null)]);
    }

    /**
     * Muestra todos los productos por categoria, si la categoria es 0 regresa todos los productos
     *
     * @return Productos
     */

    public function getProductosPorCategoria(Request $request){
        $validatedData = $request->validate([
            'id' => 'required|integer|digits_between:1,10'
        ]);
        $id = $request->input('id');

        if($id == 0){
            $productos = Producto::paginate(5)
            ->setPageName("p");
        }else{
            $productos = Producto::whereIn('idcategoria',function($query2) use ($id){
                            $query2->select('idcategorias')->from('categorias')->where('idcategoriapadre',$id);
                        })->orWhere('idcategoria',$id)
                        ->paginate(5)
                        ->setPageName("p");
        }
        return view('tablaProductos', ['productos' => $productos]);
    }

    public function getProducto($id){
        return view('producto', ['producto' => Producto::find($id)]);
    }
}