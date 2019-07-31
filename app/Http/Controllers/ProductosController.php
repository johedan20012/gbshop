<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Muestra todos los productos
     *
     * @return Productos
     */
    public function getProductos()
    {
        return view('verProductos', ['productos' => Producto::all()]);
    }
}