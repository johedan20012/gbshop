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
        $productos = Producto::paginate(5)->setPageName("p");

        if($request->ajax()){
            return view('tablaProductos', ['productos' => $productos]);
        }

        return view('inicio', ['productos' => $productos /*Producto::all()*/, 'categorias' => Categoria::all()->where('idcategoriapadre',null)]);
    }

    public function getProductosPorCategoria(Request $request){
        /*$validatedData = $request->validate([
            'id' => 'required|integer|digits_between:1,10'
        ]);*/
        $id = 1;
        $id2 = 1;
        /*
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
        }*/
            /*
        $original = Producto::where('idcategoria',$id);

        $latest = Producto::where('idcategoria',$id2);

        $merged = $original->merge($latest);
            *//*
        $collection = collect();
        $cars = Producto::where('idcategoria',$id);
        $bikes = Producto::where('idcategoria',$id2);
        foreach ($cars as $car)
            $collection->push($car);
        foreach ($bikes as $bike)
            $collection->push($bike);*/
        $productos = Producto::where('idcategoria',$id)
            ->orWhere(function ($query){
                $query->whereIn('idcategoria',function($query2){
                    $query2->select('idcategorias')->from('categorias')->where('idcategoriapadre',1);
                });
            })
            ->paginate(5)
            ->setPageName("p");
        return view('tablaProductos', ['productos' => $productos]);
        //return view('verProductos', ['productos' => $productos]);
    }

    public function getProducto($id){
        return view('verProducto', ['producto' => Producto::find($id)]);
    }
}