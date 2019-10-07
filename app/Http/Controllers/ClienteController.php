<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

use Validator;

class ClienteController extends Controller
{
    public function getPanel(Request $request){
        $panel = 1;
        $validacion = Validator::make($request->all(), array(
            'panel' => 'nullable|integer'
        ));

        $panel = ($validacion->fails())? 1: ($request->has('panel')) ? $request->input('panel') : 1;

        switch($panel){
            case 2:
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>route('panelUsuario')], ['nombre'=> 'Editar info','ruta'=>'']];

                return view('cliente.panelEditar',['breadcrumb'=>$breadcrumb]);
                break;

            default:
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>'']];

                return view('cliente.panelInicio',['breadcrumb'=>$breadcrumb]);
                break;
        }
    }

    public function getCarrito(){
        $carrito = session()->get('carrito');
        $total = session()->get('total');

        $breadcrumb = [['nombre' => 'Carrito', 'ruta'=>'']];

        return view('carrito',[
            'total' => $total,
            'carrito' => $carrito,
            'breadcrumb' => $breadcrumb,
            'sinNavbar' => true
        ]);
    }

    public function addCarrito(Request $request){
        $validacion = Validator::make($request->all(), array(
            'codigo' => 'required|string|max:40',
            'cantidad' => 'required|integer'
        ));

        if($validacion->fails()){
            if($request->ajax()){
                return ['codigo'=>500];
            }
            return redirect()->back()->with('Error' , 'No se pudo agregar el producto al carrito1');
        }

        $codigo = $request->input('codigo');
        $producto = Producto::where('codigo', $codigo)->first();
        $cantidad = $request->input('cantidad');

        if(!$producto){
            if($request->ajax()){
                return ['codigo'=>500];
            }
            return redirect()->back()->with('Error' , 'No se pudo agregar el producto al carrito');
        }

        $carrito = session()->get('carrito');
        $productos = (session()->get('productos'))? session()->get('productos'): 0;
        $total = (session()->get('total'))? session()->get('total'): 0;
 
        if(!$carrito) {
            if($cantidad <= 0){ //?Por que meterias 0 ó -1 cantidades de un producto
                if($request->ajax()){
                    return ['codigo'=>500];
                }
                return redirect()->back()->with('Error' , 'No se pudo agregar el producto al carrito');
            }
            $carrito = [
                    $codigo => [
                        "nombre" => $producto->nombre,
                        "cantidad" => $cantidad,
                        "precio" => $producto->precioSF,
                        "codigo" => $producto->codigo,
                        "foto" => $producto->foto->nombre
                    ]
            ];
            $productos += $cantidad;
            $total += $cantidad*$producto->precioSF;
        }else if(isset($carrito[$codigo])) {
            if(($carrito[$codigo]['cantidad'] + $cantidad) <= 0){ //?Por que meterias 0 ó -1 cantidades de un producto
                if($request->ajax()){
                    return ['codigo'=>500];
                }
                return redirect()->back()->with('Error' , 'No se pudo agregar el producto al carrito');
            }
            $carrito[$codigo]['cantidad'] += $cantidad;
            $productos += $cantidad;
            $total += $cantidad*$producto->precioSF;
        }else{
            if($cantidad <= 0){ //?Por que meterias 0 ó -1 cantidades de un producto
                if($request->ajax()){
                    return ['codigo'=>500];
                }
                return redirect()->back()->with('Error' , 'No se pudo agregar el producto al carrito');
            }
            $carrito[$codigo] = [
                "nombre" => $producto->nombre,
                "cantidad" => $cantidad,
                "precio" => $producto->precioSF,
                "codigo" => $producto->codigo,
                "foto" => $producto->foto->nombre
            ];
            $productos += $cantidad;
            $total += $cantidad*$producto->precioSF;
        }
        session()->put('carrito', $carrito);
        session()->put('productos',$productos);
        session()->put('total',(float)$total);
 
        if($request->ajax()){
            $subtotal = $carrito[$codigo]['cantidad'] * $carrito[$codigo]['precio'];
            return ['codigo'=>200,'total'=>number_format(($total<= 800)? $total+180:$total,2),'cantidad'=>$carrito[$codigo]['cantidad'],'subtotal'=>number_format($subtotal,2),'envio'=>($total <= 800)? number_format(180,2):"GRATIS"];
        }
        return redirect()->route('carritoUsuario');//->with('Mensaje', 'Producto agregado correctamente!');
    }

    public function eliminarCarrito(Request $request){
        $validacion = Validator::make($request->all(), array(
            'codigo' => 'required|string|max:40'
        ));

        if($validacion->fails()){
            return redirect()->route('carritoUsuario')->with('Error' , 'No se pudo eliminar el producto del carrito');
        }

        $codigo = $request->input('codigo');
        $producto = Producto::where('codigo', $codigo)->first();

        if(!$producto){
            return redirect()->route('carritoUsuario')->with('Error' , 'No se pudo eliminar el producto del carrito');
        }

        $carrito = session()->get('carrito');
        $productos = (session()->get('productos'))? session()->get('productos'): 0;
        $total = (session()->get('total'))? session()->get('total'): 0;
 
        if(!$carrito) { //? No hay nada de donde quitar pues o existe el carrito
 
            return redirect()->route('carritoUsuario')->with('Error' , 'No se pudo eliminar el producto del carrito');

        }else if(isset($carrito[$codigo])) { //? Lo elimino del carrito

            $cantidad = $carrito[$codigo]['cantidad'];
            $productos -= $cantidad;

            $precio = $cantidad * $carrito[$codigo]['precio'];
            $total -= $precio;

            unset($carrito[$codigo]);
        }else{ //? No existe asi que no hago nada

            return redirect()->route('carritoUsuario')->with('Error' , 'No se pudo eliminar el producto del carrito');
        }
        if(count($carrito) <= 0){
            session()->forget('carrito');
            session()->forget('productos');
            session()->forget('total');
        }else{
            session()->put('carrito', $carrito);
            session()->put('productos',$productos);
            session()->put('total',(float)$total);
        }
        return redirect()->route('carritoUsuario')->with('Mensaje', 'Producto eliminado correctamente!');
    }

    public function vaciarCarrito(){
        session()->forget('carrito');
        session()->forget('productos');
        session()->forget('total');

        return redirect()->route('inicio');
    }

    public function getConfirmCompra(){
        $carrito = session()->get('carrito');
        $total = session()->get('total');

        $breadcrumb = [['nombre' => 'Carrito', 'ruta'=>route('carritoUsuario')], ['nombre'=>'Confirmar', 'ruta'=>'']];

        return view('confirmarCompra',[
            'total' => $total,
            'carrito' => $carrito,
            'breadcrumb' => $breadcrumb,
            'sinNavbar' => true
        ]);
    }
}
