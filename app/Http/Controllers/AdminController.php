<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Exports\ExportProductos;

use App\Mail\CompraRealizada;

use App\Marca;
use App\Categoria;
use App\Producto;
use App\FotosProducto;
use App\User;
use App\Venta;

use Validator;
use Image;
use PDF;
use Excel;


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

        $adminActual = Auth::guard()->user();
        if($adminActual->privilegios == 0 && $panel == 4){
            $panel = 1;
        }

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
                $admins = User::where('idadmins',"!=",$adminActual->idadmins)->orderBy("username")->paginate(10)->setPageName('p');

                return view('admin.panelAdmins',[
                    'admins' => $admins,
                    'numPag' => $panel,
                    'sinNavbar' => true
                ]);
                break;

            case 5:
                
                $pedidos = Venta::orderBy('created_at')->paginate(10)->setPageName('p');
                return view('admin.panelPedidos',[
                    'pedidos' => $pedidos,
                    'numPag' => $panel,
                    'sinNavbar' => true
                ]);

            case 6:
                $banners = Storage::disk('banners')->files();

                return view('admin.panelBanners',[
                    'banners' => $banners,
                    'numPag' => $panel,
                    'sinNavbar' => true
                ]);

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
        if($request->ajax()){// or True){
            $marcas = Marca::orderBy('nombre')->get();
            $categorias = Categoria::where('idcategoriapadre',null)->orderBy('nombre')->get();
            if($request->has('cadena')){
                //Buscar productos por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $productos = Producto::where('nombre', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('nombre')->paginate(10)->setPageName("p");
                    $tabla = view('widgets.admin.tablaProductos', [
                        'productos' => $productos,
                        'actual' => $request->input('cadena'),
                        'marcas' => $marcas,
                        'categorias' => $categorias
                    ])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }
            }
        
            //Traer productos indiscriminadamente
            $productos = Producto::orderBy('nombre')->paginate(10)->setPageName("p");
            $tabla = view('widgets.admin.tablaProductos', [
                'productos' => $productos,
                'marcas' => $marcas,
                'categorias' => $categorias
            ])->render();
            return response()->json(array('tabla' => $tabla));
        }
    }

    public function storeProducto(Request $request){
        $validacion = Validator::make($request->all(), array(
            'producto-nombre' => 'required|string|max:100', //|regex:/^[0-9a-zñÑÁÉÍÓÚáéíóúüA-Z ]+$/
            'producto-descripcion' => 'nullable|string',
            'producto-modelo' => 'nullable|string|max:30',
            'producto-atributos' => 'nullable|string',
            'producto-marca' => 'required|integer',
            'producto-categoria' => 'required|integer',
            'producto-subcategoria' => 'nullable|integer',
            'producto-precio' => 'required|numeric',
            'producto-stock' => 'required|numeric',
            'producto-foto.*' => 'nullable|file|image|mimes:jpeg,png|max:4096' //Para esto activamos php_fileinfo en php.ini
        ));
        if($validacion->fails()){
            return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Error' , 'No se pudo registrar el producto, revisa los campos');
        }

        $producto = new Producto();
        
        $producto->nombre = $request->input('producto-nombre');
        $producto->descripcion = $request->input('producto-descripcion');
        $producto->atributos = $request->input('producto-modelo').$request->input('producto-atributos');
        $producto->precio = $request->input('producto-precio');
        $producto->stock = ($request->input('producto-stock') <= 0)? 0 : $request->input('producto-stock');
        $producto->codigo = str_random(15);
        $producto->idmarca = $request->input('producto-marca');

        $idcategoria = ($request->input('producto-subcategoria') != 0)? $request->input('producto-subcategoria'): $request->input('producto-categoria');
        $producto->idcategoria = $idcategoria;

        if(!$producto->save()){ //No se logro guardar el producto de manera correcta;
            return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Error' , 'No se pudo registrar el producto');
        }

        //Guardar imagenes
        $photos = $request->file('producto-foto');
        $contador = 0;

        foreach ($photos as $photo) {
            $contador ++;
            if($contador >= 11){
                return redirect()->route('admin',['panel' => 1])->with('Warning' , 'Producto registrado con exito, la cantidad maxima de fotos(10) fue rebasada, puede que no se hayan guardado algunas fotos');
            }
            $extension = $photo->getClientOriginalExtension();
            $nombreSolo = str_random(15);
            $filename  = $nombreSolo.'.png';

            while(Storage::disk('imgProductos')->exists($filename)){
                $nombreSolo = str_random(15);
                $filename  = $nombreSolo.'.png';
            }

            $imagen = Image::make($photo->getRealPath())->encode('png',85);
            $imagenWEBP = Image::make($photo->getRealPath())->encode('webp',95);
            //$imagen = Image::make($photo->getRealPath())->resize(900, 550)->encode('jpg', 85);

            Storage::disk('imgProductos')->put($filename, (string) $imagen);
            Storage::disk('imgProductos')->put('webp/'.$nombreSolo.'.webp',(string) $imagenWEBP);

            $imagen->destroy(); //Liberamos el espacio en memoria que ocupa "imagen"
            $imagenWEBP->destroy(); //Liberamos la memoria de "imagenWEBP"
            
            if(!Storage::disk('imgProductos')->exists($filename) || !Storage::disk('imgProductos')->exists('webp/'.$nombreSolo.'.webp')){ //No se guardo la imagen
                return back()->withInput($request->only('producto-nombre', 'producto-descripcion'))->with('Warning' , 'Se guardo el producto, pero hubo un error con alguna o varias imagenes');
            }

            $foto = new FotosProducto();

            $foto->idproducto = $producto->idproductos;
            $foto->nombre = $filename;

            if(!$foto->save()){ //No se guardo la foto en la base de datos
                Storage::disk('imgProductos')->delete($filename);
                Storage::disk('imgProductos')->delete('webp/'.$nombreSolo.'.webp');

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

    public function getFotosProducto(Request $request){
        if($request->ajax()){
            
            //Buscar marcas por medio de la cadena
            $validacion = Validator::make($request->all(), array(
                'id' => 'required|integer'
            ));
            if($validacion->fails()){
                return response()->json("error");
            }
            
            $producto = Producto::find($request->input('id'));

            if(!$producto){
                return response()->json("error");
            }
            $regreso = array();
            foreach($producto->nombresFotos as $foto){
                array_push($regreso,array(asset('storage/imagenesProductos/'.$foto["nombre"]),$foto["nombre"]));
            }

            return response()->json($regreso);
        }

        
    }

    public function editProducto(Request $request){
        $validacion = Validator::make($request->all(), array(
            'producto-id' => 'required|integer',
            'producto-nombre' => 'required|string|max:100', //|regex:/^[0-9a-zñÑÁÉÍÓÚáéíóúüA-Z ]+$/
            'producto-descripcion' => 'nullable|string',
            'producto-marca' => 'required|integer',
            'producto-categoria' => 'required|integer',
            'producto-subcategoria' => 'nullable|integer',
            'producto-precio' => 'required|numeric',
            'producto-stock' => 'required|numeric',
            'producto-foto.*' => 'nullable|file|image|mimes:jpeg,png|max:4096', //Para esto activamos php_fileinfo en php.ini
            'producto-fotosBorrar' => 'nullable|string|max:300'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo editar el producto');
        }

        $producto = Producto::find($request->input('producto-id'));

        if($producto == null){
            return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo editar el producto');
        }

        $idProducto = $request->input('producto-id');
        $producto->nombre = $request->input('producto-nombre');
        $producto->descripcion = $request->input('producto-descripcion');
        $producto->idmarca = $request->input('producto-marca');
        $producto->idcategoria = ($request->input('producto-subcategoria') != null)? $request->input('producto-subcategoria'): $request->input('producto-categoria');
        $producto->precio = $request->input('producto-precio');
        $producto->stock = ($request->input('producto-stock') <= 0)? 0 : $request->input('producto-stock');
        
        try{
            if(!$producto->save()){ //No se logro guardar el producto de manera correcta;
                return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo editar el producto');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo editar el producto');
        }

        $fotosBorrar = ($request->input('producto-fotosBorrar') != null)? explode(",",$request->input('producto-fotosBorrar')) : array();
        
        foreach($producto->fotos as $foto){
            $encontrado = 0;
            foreach($fotosBorrar as $borrar){
                if($borrar == $foto->nombre){
                    $encontrado = 1;
                    break;
                }
            }
            if($encontrado == 1){
                
                if(!FotosProducto::where('idfotos_productos',$foto->id)->delete()){
                    return redirect()->route('admin',['panel' => 1])->with('Warning' , 'El producto se pudo editar, pero no se eliminaron algunas fotos y no se registraron las nuevas');
                }

                Storage::disk('imgProductos')->delete($foto->nombre);
                $nombreFotoWEBP = pathinfo($foto->nombre, PATHINFO_FILENAME).'.webp';
                Storage::disk('imgProductos')->delete('webp/'.$nombreFotoWEBP);
            }
        }

        //Guardar fotos nuevas
        $maximo = 10 - FotosProducto::where('idproducto',$idProducto)->count();
        if($maximo < 0) $maximo = 0;

        $fotos = ($request->file('producto-foto') != null )? $request->file('producto-foto'):array();
        $contador = 0;
        
        foreach ($fotos as $foto) {
            $contador ++;
            if($contador > $maximo){
                
                return redirect()->route('admin',['panel' => 1])->with('Warning' , 'Producto editado con exito, se borraron las fotos pero la cantidad maxima de fotos(10) fue rebasada, puede que no se hayan guardado algunas fotos');
            }
            $extension = $foto->getClientOriginalExtension();
            $nombreSolo = str_random(15);
            $filename  = $nombreSolo.'.png';

            while(Storage::disk('imgProductos')->exists($filename)){
                $nombreSolo = str_random(15);
                $filename  = $nombreSolo.'.png';
            }

            $imagen = Image::make($foto->getRealPath())->encode('png',85);
            $imagenWEBP = Image::make($foto->getRealPath())->encode('webp',95);
            //$imagen = Image::make($photo->getRealPath())->resize(900, 550)->encode('jpg', 85);

            Storage::disk('imgProductos')->put($filename, (string) $imagen);
            Storage::disk('imgProductos')->put('webp/'.$nombreSolo.'.webp',(string) $imagenWEBP);

            $imagen->destroy(); //Liberamos el espacio en memoria que ocupa "imagen"
            $imagenWEBP->destroy(); //Liberamos la memoria de "imagenWEBP"

            if(!Storage::disk('imgProductos')->exists($filename) || !Storage::disk('imgProductos')->exists('webp/'.$nombreSolo.'.webp')){ //No se guardo la imagen
                return redirect()->route('admin',['panel' => 1])->with('Warning' , 'Se edito el producto, se eliminaron las fotos, pero hubo un error con alguna o varias imagenes nuevas');
            }

            $foto = new FotosProducto();

            $foto->idproducto = $idProducto;
            $foto->nombre = $filename;

            if(!$foto->save()){ //No se guardo la foto en la base de datos
                Storage::disk('imgProductos')->delete($filename);
                Storage::disk('imgProductos')->delete('webp/'.$nombreSolo.'.webp');

                return redirect()->route('admin',['panel' => 1])->with('Warning' , 'Se edito el producto, se eliminaron las fotos, pero hubo un error con alguna o varias imagenes nuevas');
            }

        }
        return redirect()->route('admin',['panel' => 1])->with('Mensaje' , 'Producto editado con exito!');
    }

    public function delProducto(Request $request){
        $validacion = Validator::make($request->all(), array(
            'producto-id' => 'required|integer',
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo borrar el producto');
        }
        $producto = Producto::find($request->input('producto-id'));

        foreach($producto->fotos as $foto){
            if(!FotosProducto::destroy($foto->id)){
                return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo borrar el producto, algunas fotos no se pudieron eliminar');
            }

            Storage::disk('imgProductos')->delete($foto->nombre);
            $nombreFotoWEBP = pathinfo($foto->nombre, PATHINFO_FILENAME).'.webp';
            Storage::disk('imgProductos')->delete('webp/'.$nombreFotoWEBP);
        }

        try{
            if(!Producto::destroy($request->input('producto-id'))){ //No se logro borrar el producto de manera correcta;
                return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo borrar el producto');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 1])->with('Error' , 'No se pudo borrar el producto');
        }

        return redirect()->route('admin',['panel' => 1])->with('Mensaje' , 'Producto eliminado con exito!');
    }

    public function getReporteProductos(){
        $data = Producto::all();
        $cabezera = array(array("ID","Nombre","Descripcion","Modelo","Precio","Categoria","Marca","Stock","Tabla descripción"));
        foreach($data as $producto){
            
            $modelo = "NULL";
            if($producto->atributos){
                $mijson = json_decode($producto->atributos);
                if($mijson){
                    if(array_key_exists('N.° de modelo', $mijson)){
                        $modelo = $mijson->{'N.° de modelo'};
                    }
                }
            }
            $cabezera[] = array($producto->idproductos,$producto->nombre,$producto->descripcion,$modelo,$producto->precio, $producto->categoria->nombre,$producto->marca? $producto->marca->nombre:"NULL",($producto->stock==1)?"1":"0",$producto->atributos);
        }
        return Excel::download(new ExportProductos($cabezera),'Productos.xlsx');
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

    //TODO, Aqui empiezan las funciones que llama el panel de pedidos
    public function getTablaPedidos(Request $request){
        if($request->ajax()){
            if($request->has('cadena')){
                //Buscar marcas por medio de la cadena
                $validatedData = $request->validate([
                    'cadena' => 'nullable|string|max:50'
                ]);

                if($request->input('cadena') !== null){
                    $pedidos = Venta::where('clave', 'LIKE', '%'.$request->input('cadena').'%')->orderBy('created_at')->paginate(10)->setPageName("p");
                    $tabla = view('widgets.admin.tablaPedidos', ['pedidos' => $pedidos,'actual' => $request->input('cadena')])->render();
        
                    return response()->json(array('tabla' => $tabla));
                }
            }
        
            //Traer marcas indiscriminadamente
            $pedidos = Venta::orderBy('created_at')->paginate(10)->setPageName("p");
            $tabla = view('widgets.admin.tablaPedidos', ['pedidos' => $pedidos])->render();

            return response()->json(array('tabla' => $tabla));
        }
    }

    public function hojaPedido(Request $request){

        $validacion = Validator::make($request->all(), array(
            'clavePedido' => 'required|string|max:100'
        ));
        
        if($validacion->fails()){
            return back()->with('Error' , 'No se pudo generar la hoja del pedido');
        }

        $pedido = Venta::where('clave',$request->input('clavePedido'))->first();

        if(!$pedido){
            return back()->with('Error' , 'No se pudo generar la hoja del pedido');
        }

        return view('correos.correoCompra',['pedido'=>$pedido]);
        //$pdf = PDF::loadView('pdf.detalleCompra',compact('pedido'));
    
        
        //return $pdf->download('orden.pdf');
        
    }

    public function generarHojaPedido(Request $request){

        $validacion = Validator::make($request->all(), array(
            'clavePedido' => 'required|string|max:100'
        ));
        
        if($validacion->fails()){
            return back()->with('Error' , 'No se pudo generar la hoja del pedido');
        }

        $pedido = Venta::where('clave',$request->input('clavePedido'))->first();

        if(!$pedido){
            return back()->with('Error' , 'No se pudo generar la hoja del pedido');
        }

        if($request->has("ver")){
            if($request->input("ver") == 1 || $request->input("ver") == "1"){
                return view('admin.detallesPedido',[
                    'pedido' => $pedido,
                    'numPag' =>5,
                    'sinNavbar' => true
                ]);
            }
        }

        $pdf = PDF::loadView('pdf.detalleCompra',compact('pedido'));
        $pdf->setOption('margin-top',10);
        $pdf->setOption('margin-bottom',10);
        $pdf->setOption('margin-left',0);
        $pdf->setOption('margin-right',0);
        
        return $pdf->download('orden'.$pedido->clave.'.pdf');
        
    }

    public function editEstatus(Request $request){
        if($request->ajax()){
            $validacion = Validator::make($request->all(), array(
                'estatus' => 'required|string|max:10',
                'comentarios' => 'required|string',
                'clavePedido' => 'required|string|max:50'
            ));

            if($validacion->fails()){
                return array('Error'=>'No se pudo actualizar el pedido');
            }
            $estatus = $request->input("estatus");
            $comentarios = $request->input("comentarios");
            $clavePedido = $request->input("clavePedido");

            if($estatus != 0 && $estatus != 2 && $estatus != 3 && $estatus != 4){
                return array('Error'=>'No se pudo actualizar el pedido, el estatus no es valido');
            }

            $pedido = Venta::where('clave',$clavePedido)->first();

            if(!$pedido){
                return array('Error'=>'No se pudo actualizar el pedido, no se encontro en la base de datos');
            }

            $pedido->estatus = $estatus;
            $pedido->comentarios .= '-'.$comentarios.'-';

            try{
                if(!$pedido->save()){ 
                    return array('Error'=>'No se pudo actualizar el pedido');
                }
            } catch (\Illuminate\Database\QueryException $e){
                return array('Error'=>'No se pudo actualizar el pedido');
            }

            return array('Exito'=>'El pedido se actualizo con exito');
        }
    }

    public function mandarCorreoPedido(Request $request){
        if($request->ajax()){
            $validacion = Validator::make($request->all(), array(
                'correo' => 'nullable|string|max:100|email',
                'correoG' => 'nullable|string|max:10',
                'clavePedido' => 'required|string|max:50'
            ));

            if($validacion->fails()){
                return array('Error'=>'No se pudo enviar el correo');
            }

            $correo = ($request->has('correo'))? $request->input("correo") : "";
            $correoG = ($request->has('correoG'))? $request->input("correoG") : "";
            $clavePedido = $request->input("clavePedido");

            if($correo == "" and $correoG == ""){
                return array('Error'=>'No se pudo enviar el correo, los campos estan vacios');
            }

            $pedido = Venta::where('clave',$clavePedido)->first();

            if(!$pedido){
                return array('Error'=>'No se pudo enviar el correo, falta la clave de pedido');
            }

            if($correoG == "true"){ //? Usare la direccion guardada del cliente/usuario
                $destinatario = $pedido->usuario->email;
            }else{ //?Usare la nueva direccion proporcionada
                if($correo == ""){
                    return array('Error'=>'No se pudo enviar el correo, el email no puede estar vacio');
                }
                $destinatario = $correo;
            }

            Mail::to($destinatario)->send(new CompraRealizada($pedido));
            return array('Exito' => 'El correo se envio con exito a la direccion '.$destinatario);
        }
    }

    //TODO Aqui inician las funciones para el panel de admins
    /**
     * Crea un nuevo administrador
     *
     * @param  Request $request
     * @return String mensaje
     */
    public function createAdmin(Request $request){
        $validacion = Validator::make($request->all(), array(
            'admin-username' => 'required|string|max:255|unique:admins,username',
            'admin-pass' => 'required|string|min:7|confirmed'
        ));

        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo registrar al administrador');
        }

        $admin =  User::create([
            'username' => $request->input('admin-username'),
            'password' => bcrypt($request->input('admin-pass')),
        ]);

        if(!$admin){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo registrar al administrador');
        }

        return redirect()->route('admin',['panel' => 4])->with('Mensaje' , 'Administrador registrado con exito');
    }

    public function getTablaAdmins(Request $request){
        if($request->ajax()){
            $adminActual = Auth::guard("web")->user();
            $admins = User::where('idadmins',"!=",$adminActual->idadmins)->orderBy('username')->paginate(10)->setPageName("p");
            $tabla = view('widgets.admin.tablaAdmins', ['admins' => $admins])->render();

            return response()->json(array('tabla' => $tabla));
        }
    }

    public function editAdmin(Request $request){
        $validacion = Validator::make($request->all(), array(
            'admin-id' => 'required|integer',
            'admin-pass' => 'required|string|min:7|confirmed'
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo cambiar la contraseña del administrador');
        }

        $adminActual = Auth::guard("web")->user();
        if($adminActual->idadmins == $request->input('admin-id')){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo cambiar la contraseña del administrador');
        }

        $admin = User::find($request->input('admin-id'));
        if($admin == null){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo cambiar la contraseña del administrador');
        }

        $admin->password = bcrypt($request->input('admin-pass'));

        try{
            if(!$admin->save()){ //No se logro guardar el admin de manera correcta;
                return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo cambiar la contraseña del administrador');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo cambiar la contraseña del administrador');
        }

        return redirect()->route('admin',['panel' => 4])->with('Mensaje' , 'Contraseña cambiada con exito!');
    }

    public function delAdmin(Request $request){
        $validacion = Validator::make($request->all(), array(
            'admin-id' => 'required|integer',
        ));

        $adminActual = Auth::guard("web")->user();
        if($adminActual->idadmins == $request->input('admin-id')){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo borrar al administrador, no te puedes borrar a ti mismo');
        }
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo borrar al administrador');
        }

        try{
            if(!User::destroy($request->input('admin-id'))){ //No se logro borrar la marca de manera correcta;
                return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo borrar al administrador');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('admin',['panel' => 4])->with('Error' , 'No se pudo borrar al administrador');
        }

        return redirect()->route('admin',['panel' => 4])->with('Mensaje' , 'Administrador eliminado con exito!');
    }

    //TODO Aqui inician las funciones para el panel de banners
    public function storeBanner(Request $request){
        $validacion = Validator::make($request->all(), array(
            'banner-fotos.*' => 'nullable|file|image|mimes:jpeg,png|max:4096' //Para esto activamos php_fileinfo en php.ini
        ));
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 6])->with('Error' , 'No se pudo agregar los banners');
        }
        
        //Guardar imagenes
        $photos = $request->file('banner-fotos');

        foreach ($photos as $photo) {
            
            $extension = $photo->getClientOriginalExtension();
            $filename  = date('YmdHis').str_random(3);
            $filenameWEBP = $filename.'.webp';
            $filename .= '.'.$extension;

            $imagen = Image::make($photo->getRealPath())->encode('jpg',85);
            $imagenWEBP = Image::make($photo->getRealPath())->encode('webp',95);
            //$imagen = Image::make($photo->getRealPath())->resize(900, 550)->encode('jpg', 85);

            Storage::disk('banners')->put($filename, (string) $imagen);
            Storage::disk('bannersWEBP')->put($filenameWEBP, (string) $imagenWEBP);

            if(!Storage::disk('banners')->exists($filename) || !Storage::disk('bannersWEBP')->exists($filenameWEBP)){ //No se guardo la imagen
                return redirect()->route('admin',['panel' => 6])->with('Warning' , 'Solo se pudo guardar algunos banners');
            }

        }
        return redirect()->route('admin',['panel' => 6])->with('Mensaje' , 'Banners agregados con exito!');
    }

    public function delBanner(Request $request){
        $validacion = Validator::make($request->all(), array(
            'banner-nombre' => 'required|string|max:50',
        ));
        
        if($validacion->fails()){
            return redirect()->route('admin',['panel' => 6])->with('Error' , 'No se pudo borrar el banner');
        }

        $nombreBanner = $request->input('banner-nombre');

        Storage::disk('banners')->delete($nombreBanner);
        $nombreBannerWEBP = pathinfo($nombreBanner, PATHINFO_FILENAME).'.webp';
        Storage::disk('bannersWEBP')->delete($nombreBannerWEBP);

        if(Storage::disk('banners')->exists($nombreBanner) || Storage::disk('bannersWEBP')->exists($nombreBannerWEBP)){
            return redirect()->route('admin',['panel' => 6])->with('Error' , 'No se pudo borrar el banner');
        }

        return redirect()->route('admin',['panel' => 6])->with('Mensaje' , 'Banner eliminado con exito!');
    }
}