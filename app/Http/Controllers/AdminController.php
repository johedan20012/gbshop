<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Marca;
use App\Categoria;
use App\Producto;
use App\FotosProducto;

use Validator;

class AdminController extends Controller
{
    /** Obtiene el panel de administración actual dependiendo de la variable $panel
    *
    *   @return El panel actual
    */ 

    public function getPanel(Request $request){
        $panel = 1;
        $validacion = Validator::make($request->all(), array(
            'panel' => 'nullable|integer'
        ));

        $panel = ($validacion->fails())? 1: ($request->has('panel')) ? $request->input('panel') : 1;

        switch($panel){
            case 2:
                $marcas = Marca::orderBy('nombre')->paginate(10)->setPageName('p');

                return view('admin.panelMarcas',[
                    'marcas' => $marcas,
                    'numPag' => $panel,
                    'sinNavbar' => true
                ]);
                break;    
            
            case 3:
                $categorias = Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get();
                $categorias1 = Categoria::orderBy('nombre')->paginate(20)->setPageName('p');

                return view('admin.panelCategorias',[
                    'numPag' => $panel,
                    'categorias' => $categorias,
                    'categorias1' => $categorias1,
                    'sinNavbar' => true
                ]);
                break;
            
            case 4:
                
                return view('admin.panelAdmins',[
                    'numPag' => $panel,
                    'sinNavbar' => true
                ]);
                break;

            default:
                $marcas = Marca::orderBy('nombre')->get();
                $categorias = Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get();
                $productos = Producto::orderBy('nombre')->paginate(10)->setPageName('p');

                return view('admin.panelProductos',[
                    'marcas' => $marcas, 
                    'categorias' => $categorias,
                    'productos' => $productos,
                    'numPag' => 1,
                    'sinNavbar' => true
                ]);
                break;
        }
    }

    //TODO, Aqui empiezan las funciones que llama el panel de productos
    public function getTablaProductos(Request $request){
        if($request->ajax() or True){
            if($request->has('cadena')){
                //Buscar productos por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $productos = Producto::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('nombre')->paginate(10)->setPageName("p");
                    $tabla = view('widgets.admin.tablaProductos', ['productos' => $productos,'actual' => $request->input('cadena')])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }
            }
        
            //Traer productos indiscriminadamente
            $productos = Producto::orderBy('nombre')->paginate(10)->setPageName("p");
            $tabla = view('widgets.admin.tablaProductos', ['productos' => $productos])->render();
            return response()->json(array('tabla' => $tabla));
        }
    }

    public function storeProducto(Request $request){
        $validacion = Validator::make($request->all(), array(
            'producto-nombre' => 'required|string|max:100', //|regex:/^[0-9a-zñÑÁÉÍÓÚáéíóúüA-Z ]+$/
            'producto-descripcion' => 'nullable|string',
            'producto-marca' => 'required|integer',
            'producto-categoria' => 'required|integer',
            'producto-subcategoria' => 'nullable|integer',
            'producto-precio' => 'required|numeric',
            'producto-foto.*' => 'nullable|file|image|mimes:jpeg,png|max:2048' //Para esto activamos php_fileinfo en php.ini
        ));
        
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
        return redirect()->route('admin',['panel' => 1])->with('Mensaje' , 'Producto registrado con exito!');
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

    //TODO, Aqui empiezan las funciones que llama el panel de marcas
    public function getTablaMarcas(Request $request){
        if($request->ajax()){
            if($request->has('cadena')){
                //Buscar marcas por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $marcas = Marca::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('nombre')->paginate(10)->setPageName("p");
                    $tabla = view('widgets.admin.tablaMarcas', ['marcas' => $marcas,'actual' => $request->input('cadena')])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }
            }
        
            //Traer marcas indiscriminadamente
            $marcas = Marca::orderBy('nombre')->paginate(10)->setPageName("p");
            $tabla = view('widgets.admin.tablaMarcas', ['marcas' => $marcas])->render();

            return response()->json(array('tabla' => $tabla));
        }
    }

    public function storeMarca(Request $request){
        $validacion = Validator::make($request->all(), array(
            'marca-nombre' => 'required|string|max:50'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca, revisa el campo');
        }

        $marca = new Marca();
        
        $marca->nombre = $request->input('marca-nombre');
        try{
            if(!$marca->save()){ //No se logro guardar la marca de manera correcta;
                return redirect()->route('admin',['panel' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 2])->withInput($request->only('marca-nombre'))->with('Error' , 'No se pudo registrar la marca');
        }

        return redirect()->route('admin',['panel' => 2])->with('Mensaje' , 'Marca registrada con exito!');
    }

    public function editMarca(Request $request){
        $validacion = Validator::make($request->all(), array(
            'marca-id' => 'required|integer',
            'marca-nombre' => 'required|string|max:50'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo editar la marca');
        }

        $marca = Marca::find($request->input('marca-id'));
        if($marca == null){
            return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo editar la marca');
        }

        $marca->nombre = $request->input('marca-nombre');

        try{
            if(!$marca->save()){ //No se logro guardar la marca de manera correcta;
                return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo editar la marca');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo editar la marca');
        }

        return redirect()->route('admin',['panel' => 2])->with('Mensaje' , 'Marca editada con exito!');
    }

    public function delMarca(Request $request){
        $validacion = Validator::make($request->all(), array(
            'marca-id' => 'required|integer',
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo borrar la marca');
        }

        try{
            if(!Marca::destroy($request->input('marca-id'))){ //No se logro borrar la marca de manera correcta;
                return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo borrar la marca');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 2])->with('Error' , 'No se pudo borrar la marca, primero elimina los productos de esta marca');
        }

        return redirect()->route('admin',['panel' => 2])->with('Mensaje' , 'Marca eliminada con exito!');
    }

    //TODO, Aqui empiezan las funciones que llama el panel de categorias
    public function getTablaCategorias(Request $request){
        if($request->ajax()){
            if($request->has('cadena')){
                //Buscar marcas por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $categorias1 = Categoria::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('nombre')->paginate(20)->setPageName("p");
                    $tabla = view('widgets.admin.tablaCategorias', ['categorias1' => $categorias1,'actual' => $request->input('cadena')])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }
            }
        
            //Traer marcas indiscriminadamente
            $categorias1 = Categoria::orderBy('nombre')->paginate(20)->setPageName("p");
            $tabla = view('widgets.admin.tablaCategorias', ['categorias1' => $categorias1])->render();

            return response()->json(array('tabla' => $tabla));
        }
    }

    public function storeCategoria(Request $request){
        $validacion = Validator::make($request->all(), array(
            'categoria-nombre' => 'required|string|max:50',
            'categoria-padre' => 'nullable|integer'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria, revisa los campos');
        }

        $categoria = new Categoria();
        
        $categoria->nombre = $request->input('categoria-nombre');
        $categoria->idcategoriapadre = $request->input('categoria-padre');
        try{
            if(!$categoria->save()){ //No se logro guardar la categoria de manera correcta;
                return redirect()->route('admin',['panel' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 3])->withInput($request->only('categoria-nombre'))->with('Error' , 'No se pudo registrar la categoria');
        }

        return redirect()->route('admin',['panel' => 3])->with('Mensaje' , 'Categoria registrada con exito!');
    }

    public function editCategoria(Request $request){
        $validacion = Validator::make($request->all(), array(
            'categoria-id' => 'required|integer',
            'categoria-nombre' => 'required|string|max:50'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo editar la categoria');
        }

        $categoria = Categoria::find($request->input('categoria-id'));
        if($categoria == null){
            return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo editar la categoria');
        }

        $categoria->nombre = $request->input('categoria-nombre');

        try{
            if(!$categoria->save()){ //No se logro guardar la categoria de manera correcta;
                return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo editar la categoria');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo editar la categoria');
        }

        return redirect()->route('admin',['panel' => 3])->with('Mensaje' , 'Categoria editada con exito!');
    }

    public function delCategoria(Request $request){
        $validacion = Validator::make($request->all(), array(
            'categoria-id' => 'required|integer',
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo borrar la categoria');
        }

        try{
            if(!Categoria::destroy($request->input('categoria-id'))){ //No se logro borrar la categoria de manera correcta;
                return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo borrar la categoria');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 3])->with('Error' , 'No se pudo borrar la categoria, primero elimina los productos de esta categoria o sus subcategorias');
        }

        return redirect()->route('admin',['panel' => 3])->with('Mensaje' , 'Categoria eliminada con exito!');
    } 
}
