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
    public function getProductos(Request $request)
    {
        $productos = Producto::paginate(20)->setPageName("p");

        if($request->ajax()){
            return view('tablaProductos', ['productos' => $productos]);
        }

        return view('inicio', ['productos' => $productos /*Producto::all()*/]);
    }

    public function getProductosPorCategoria($id){
        $subcategorias = Categoria::all()->where('idcategoriapadre',$id);
        $productos = array();
        $a = 0;
        $productos1 = Producto::all()->where('idcategoria',$id);
        foreach($productos1 as $pr){
            $productos[$a] = $pr;
            $a++;
        }
        foreach($subcategorias as $sub){
            $productos1 = Producto::all()->where('idcategoria',$sub->idcategorias);
            foreach($productos1 as $pr){
                $productos[$a] = $pr;
                $a++;
            }
        }
        return view('verProductos', ['productos' => $productos]);
    }

    public function getProducto($id){
        return view('verProducto', ['producto' => Producto::find($id)]);
    }
}