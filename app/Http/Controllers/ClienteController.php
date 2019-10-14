<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Producto;
use App\Cliente;
use App\Venta;
use App\DetalleVenta;

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
            case 3:
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>route('panelUsuario')], ['nombre'=> 'Mis pedidos','ruta'=>'']];

                return view('cliente.panelPedidos',['breadcrumb'=>$breadcrumb]);
            default:
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>'']];
                

                return view('cliente.panelInicio',['breadcrumb'=>$breadcrumb]);
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

    public function procesarCompra(Request $request){
        if($request->ajax()){
            \Conekta\Conekta::setApiKey("key_cUmxB4FJfqDe5ZZD7pJmbQ");
            \Conekta\Conekta::setApiVersion("2.0.0");

            $validacion = Validator::make($request->all(), array(
                'conektaTokenId' => 'required|string|max:100',
                'cliente-nombreCompleto' => 'required|string|max:45',
                'cliente-aPaterno' => 'required|string|max:45',
                'cliente-aMaterno' => 'nullable|string|max:45',
                'cliente-calle' => 'required|string|max:70',
                'cliente-entreCalle' => 'nullable|string|max:70',
                'cliente-nExt' => 'required|string|max:10',
                'cliente-nInt' => 'nullable|string|max:10',
                'cliente-cp' => 'required|string|max:12',
                'cliente-colonia' => 'required|string|max:50',
                'cliente-municipio' => 'required|string|max:70',
                'cliente-estado' =>  'required|string|max:50',
                'cliente-telefono' => 'nullable|string|max:15',
                'cliente-referencias' => 'nullable|string|max:100',
                'cliente-almacenarDir' => 'nullable|string|max:5'
            ));

            if($validacion->fails()){
                $errores = $validacion->errors();
                if($errores->has('conektaTokenId')){
                    $mensaje = "No se pudo procesar el pago por tarjeta";
                }else{
                    $mensaje = "No se pudo procesar la compra, hay campos del envio vacios";
                }
                return array('Error' , $mensaje);
            }

            $carrito = session()->get('carrito');

            if(!$carrito){
                return array('Error', "No tienes productos en tu carrito");
            }else if(count($carrito) <=0){
                return array('Error', "No tienes productos en tu carrito");
            }

            $usuario = Auth::guard('cliente')->user(); //A este punto gracias al middleware, estoy seguro de que tengo un cliente registrado

            $conektaToken = $request->input("conektaTokenId");
            $nombres = $request->input("cliente-nombreCompleto");
            $apePaterno = $request->input("cliente-aPaterno");
            $apeMaterno = ($request->has("cliente-aMaterno"))? $request->input("cliente-aMaterno") : "";
            $calle = $request->input("cliente-calle");
            $entreCalle = ($request->has("cliente-entreCalle"))? $request->input("cliente-entreCalle") : "";
            $nExt = $request->input("cliente-nExt");
            $nInt = ($request->has("cliente-nInt"))? $request->input("cliente-nInt") : "";
            $cp = $request->input("cliente-cp");
            $colonia = $request->input("cliente-colonia");
            $municipio = $request->input("cliente-municipio");
            $estado = $request->input("cliente-estado");
            $telefono = ($request->has("cliente-telefono"))? $request->input("cliente-telefono") : "";
            $referencias = ($request->has("cliente-referencias"))? $request->input("cliente-referencias") : ""; 
            $almacenarDir = ($request->has("cliente-almacenarDir"))? $request->input("cliente-almacenarDir") : ""; 

            ///Hasta aqui tengo el token de conekta, los datos del pedido, un carrito con productos y el usuario 
            try{
                $cliente = \Conekta\Customer::create(
                    array(
                        "name" => $nombres." ".$apePaterno." ".$apeMaterno,
                        "email" => $usuario->email,
                        
                        "payment_sources" => array(
                            array(
                                "type" => "card",
                                "token_id" => $conektaToken
                            )
                        )
                    )
                );
            } catch (\Conekta\ProccessingError $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar tus datos");
            } catch (\Conekta\ParameterValidationError $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar tus datos");
            } catch (\Conekta\Handler $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar tus datos");
            }

            try{
                $order = \Conekta\Order::create(array(
                    "line_items" => array(
                      array(
                        "name" => "Tacos",
                        "unit_price" => 1000,
                        "quantity" => 120
                      )
                    ), 
                    "shipping_lines" => array(
                        array(
                          "amount" => 180,
                           "carrier" => "FEDEX"
                        )
                    ),
                    "shipping_contact" => array(
                        "address" => array(
                          "street1" => "Calle 123, int 2",
                          "postal_code" => "06100",
                          "country" => "MX"
                        )
                      ),
                    "currency" => "MXN",
                    "customer_info" => array(
                      "customer_id" => $cliente->id
                    ),
                    "charges" => array(
                        array(
                            "payment_method" => array(
                                "type" => "default"   
                            )
                        ) 
                    ) 
                  )
                );
            } catch (\Conekta\ProcessingError $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar el pedido");
            } catch (\Conekta\ParameterValidationError $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar el pedido2");
            } catch (\Conekta\Handler $error){ //Obtener el mensaje $error->getMessage();
                return array('Error', "Hubo un error al procesar el pedido3");
            }
            return array("Exito" , "La compra se realizo con exito, los detalles de la compra fueron enviados a su correo");
        }
    }
}
