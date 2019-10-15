<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Producto;
use App\Cliente;
use App\Venta;
use App\DetalleVenta;
use Carbon\Carbon;

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
            date_default_timezone_set('America/Mexico_City');

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

            //? Obtengo todas las variables que usare para procesar la compra
            $carrito = session()->get('carrito');

            if(!$carrito){
                return array('Error', "No tienes productos en tu carrito");
            }else if(count($carrito) <=0){
                return array('Error', "No tienes productos en tu carrito");
            }

            $total = session()->get('total');

            if(!$total){
                return array('Error', "No tienes productos en tu carrito");
            }else if($total <=0){
                return array('Error', "No tienes productos en tu carrito");
            }

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
            $telefono = preg_replace('/[^0-9]/', '', $telefono);
            $referencias = ($request->has("cliente-referencias"))? $request->input("cliente-referencias") : ""; 
            $almacenarDir = ($request->has("cliente-almacenarDir"))? $request->input("cliente-almacenarDir") : ""; 

            $usuario = Auth::guard('cliente')->user(); //A este punto gracias al middleware, estoy seguro de que tengo un cliente registrado
            
            $clave1Venta = str_replace(array('-',':',' '), '',Carbon::now()->format('Y-m-d H:i:s'));
            $clave2Venta = $clave1Venta.str_random(6);
     
            $nombreRecibidor = $nombres." ".$apePaterno." ".$apeMaterno;

            while(Venta::where('clave',$clave2Venta)->count() > 0){

                $clave2Venta = $clave1Venta.str_random(6);
            }

            //? Obtengo el cliente del lado de conketa
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

            ///Hasta aqui tengo el token de conekta, los datos del pedido, un carrito con productos y el usuario 
            //? Cambio de los datos del cliente, en caso de que lo haya solicitado
            if($almacenarDir == "on"){ //Cambiar los datos del cliente
                $usuario->calle = $calle;
                $usuario->entreCalle = $entreCalle;
                $usuario->nExt = $nExt;
                $usuario->nInt = $nInt;
                $usuario->cp = $cp;
                $usuario->colonia = $colonia;
                $usuario->municipio = $municipio;
                $usuario->estado = $estado;
                $usuario->telefono = $telefono;
                $usuario->referencia_domicilio = $referencias;

                try{
                    if(!$usuario->save()){ //No se logro guardar el producto de manera correcta;
                        //No pasa nada, por ahora
                    }
                } catch (\Illuminate\Database\QueryException $e){
                    //No pasa nada, por ahora //return array('Error', "No se pudo guardar la direccion del cliente");
                }
            }

            //? Registro de la orden de venta
            $venta = new Venta();
            $venta->calle = $calle;
            $venta->entreCalle = $entreCalle;
            $venta->nExt = $nExt;
            $venta->nInt = $nInt;
            $venta->cp = $cp;
            $venta->colonia = $colonia;
            $venta->municipio = $municipio;
            $venta->estado = $estado;
            $venta->telefono = $telefono;
            $venta->referencia_domicilio = $referencias;
            $venta->idcliente = $usuario->idclientes;
            $venta->total = $total;
            $venta->clave = $clave2Venta;

            try{
                if(!$venta->save()){ //No se logro guardar el producto de manera correcta;
                    return array('Error', "Hubo un error al procesar la compra");
                }
            } catch (\Illuminate\Database\QueryException $e){
                return array('Error', "Hubo un error al procesar la compra");
            }
            $listaProductos = array();
            //? Registro de los detalles de la orden de venta
            foreach($carrito as $productoCarrito){
                $detalleVenta = new DetalleVenta();

                $producto = Producto::where("codigo",$productoCarrito["codigo"])->first();
                if($producto === null){ //No se encontro el producto asi que mejor borro todo y me regreso
                    $venta->detalles()->delete();
                    $venta->delete();
                    return array("Error","Hubo un error al procesar la compra, hay productos inexistentes en tu carrito");
                }
                if($producto->precioSF != $productoCarrito["precio"]){ //!Hay discrepancias con los precios
                    $venta->detalles()->delete();
                    $venta->delete();
                    return array("Error","Hubo un error al procesar la compra, los precios en tu carrito no estan actualizados, intenta volverlos a registrar");
                }
                $detalleVenta->idproducto = $producto->idproductos;
                $detalleVenta->idventa = $venta->idventas;
                $detalleVenta->precio = $productoCarrito["precio"];
                $detalleVenta->cantidad = $productoCarrito["cantidad"]; 

                try{
                    if(!$detalleVenta->save()){ //No se logro guardar el detalle de la venta de manera correcta;
                        $venta->detalles()->delete();
                        $venta->delete();
                        return array('Error', "Hubo un error al procesar la compra");
                    }
                } catch (\Illuminate\Database\QueryException $e){
                    $venta->detalles()->delete();
                    $venta->delete();
                    return array('Error', "Hubo un error al procesar la compra");
                }

                array_push($listaProductos,array("name"=>$producto->nombre,"unit_price"=>(int)($productoCarrito["precio"]*100),"quantity"=>$productoCarrito["cantidad"]));
            } 
            
            //? Creacion de la orden de venta de  conekta
            try{
                $order = \Conekta\Order::create(array(
                    "line_items" => $listaProductos, 
                    "shipping_lines" => array(
                        array(
                          "amount" => 0,
                           "carrier" => "FEDEX"
                        )
                    ),
                    "shipping_contact" => array(
                        "receiver" => $nombreRecibidor,
                        "between_streets" => $entreCalle,
                        "address" => array(
                          "street1" => $calle." int ".$nInt,
                          "postal_code" => $cp,
                          'city' => $municipio,
                          'state' => $estado,
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
                $venta->estatus = 0;
                $venta->comentarios = "No se pudo procesar el pago";
                try{
                    $venta->save();
                } catch (\Illuminate\Database\QueryException $e){
                    return array('Error', "Hubo un error al procesar la compra");
                }
                return array('Error', "Hubo un error al procesar el pedido");
            } catch (\Conekta\ParameterValidationError $error){ //Obtener el mensaje $error->getMessage();
                $venta->estatus = 0;
                $venta->comentarios = "No se pudo procesar el pago";
                try{
                    $venta->save();
                } catch (\Illuminate\Database\QueryException $e){
                    return array('Error', "Hubo un error al procesar la compra");
                }
                return array('Error', $error->getMessage());
            } catch (\Conekta\Handler $error){ //Obtener el mensaje $error->getMessage();
                $venta->estatus = 0;
                $venta->comentarios = "No se pudo procesar el pago";
                try{
                    $venta->save();
                } catch (\Illuminate\Database\QueryException $e){
                    return array('Error', "Hubo un error al procesar la compra");
                }
                return array('Error', $error->getMessage());
            }
            //? Llenado del estatus de la venta como pagado
            $venta->idOrdenConekta = $order->id;
            $venta->estatus = 2;
            $venta->comentarios = "Pagó con tarjeta";
            try{
                $venta->save();
            } catch (\Illuminate\Database\QueryException $e){}

            //? Vaciado de carrito
            session()->forget('carrito');
            session()->forget('productos');
            session()->forget('total');

            //? Mandar email
            /////////////////////////
            //return array("Error" , "Todo bien pero no manda el correo");
            return array("Exito" , "La compra se realizo con exito, los detalles de la compra fueron enviados a su correo");
        }
    }
}
