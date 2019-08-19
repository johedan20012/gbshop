<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Categoria;
use App\FotosProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;

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
            $productos = Producto::paginate(20)
            ->setPageName("p");
        }else{
            $productos = Producto::whereIn('idcategoria',function($query2) use ($id){
                            $query2->select('idcategorias')->from('categorias')->where('idcategoriapadre',$id);
                        })->orWhere('idcategoria',$id)
                        ->paginate(20)
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
        $productos = Producto::take(4)->get();
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

    public function store(Request $request){
        $validacion = Validator::make($request->all(), array(
            'producto-nombre' => 'required|string|max:100', //|regex:/^[0-9a-zñÑÁÉÍÓÚáéíóúüA-Z ]+$/
            'producto-descripcion' => 'nullable|string',
            'producto-marca' => 'required|integer',
            'producto-categoria' => 'required|integer',
            'producto-subcategoria' => 'nullable|integer',
            'producto-precio' => 'required|numeric',
            'producto-foto.*' => 'nullable|file|image|mimes:jpeg,png|max:2048' //Para esto activamos php_fileinfo en php.ini
        ));

        //TODO DEBUG
        /* 
        if($validacion->fails()){
            $errors = $validacion->errors();

            $mensajes = "";

            foreach ($errors->all() as $message) {
                $mensajes .= $message;
            }
            return redirect()->route('admin')->with('Error' , $mensajes);
        }*/
        
        if($validacion->fails()){
            return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Error' , 'No se pudo registrar el producto, revisa los campos');
        }

        $producto = new Producto();
        
        $producto->nombre = $request->input('producto-nombre');
        $producto->descripcion = $request->input('producto-descripcion');
        $producto->precio = $request->input('producto-precio');
        $producto->stock = 1;
        $producto->codigo = str_random(15);
        $producto->idmarca = $request->input('producto-marca');

        $idcategoria = ($request->input('producto-subCategoria') != 0)? $request->input('producto-subCategoria'): $request->input('producto-categoria');
        $producto->idcategoria = $idcategoria;

        if(!$producto->save()){ //No se logro guardar el producto de manera correcta;
            return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Error' , 'No se pudo registrar el producto');
        }

        //Guardar imagenes

        $photos = $request->file('producto-foto');
        $falloFotos = false;

        foreach ($photos as $photo) {

            $extension = $photo->getClientOriginalExtension();

            $filename  = str_random(15).'.'.$extension;

            while(Storage::disk('imgProductos')->exists($filename)){
                $filename  = str_random(15).'.'.$extension;
            }

            Storage::disk('imgProductos')->put($filename, file_get_contents($photo));
            
            if(!Storage::disk('imgProductos')->exists($filename)){ //No se guardo la imagen
                return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Warning' , 'Se guardo el producto, pero hubo un error con alguna o varias imagenes');
            }

            $foto = new FotosProducto();

            $foto->idproducto = $producto->idproductos;
            $foto->nombre = $filename;

            if(!$foto->save()){ //No se guardo la foto en la base de datos
                Storage::disk('imgProductos')->delete($filename);

                return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Warning' , 'Se guardo el producto, pero hubo un error con alguna o varias imagenes');
            }

        }

        return redirect()->route('admin',['numPag' => 1])->with('Mensaje' , 'Producto registrado con exito!');
    }
}