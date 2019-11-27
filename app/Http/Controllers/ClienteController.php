<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Producto;
use App\Cliente;
use App\Venta;
use App\DetalleVenta;
use Carbon\Carbon;

use App\Mail\CompraRealizada;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use Illuminate\Support\Facades\Mail;

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
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>route('panelUsuario')], ['nombre'=> 'Editar información','ruta'=>'']];

                $datosUsuario = Auth::guard('cliente')->user()->datosEnvio;

                return view('cliente.panelEditar',['breadcrumb'=>$breadcrumb,'numPanel' => 2,'datosUser' => $datosUsuario]);
            case 3:
                $tipoPedido = ($request->has("type"))? $request->input("type") : 1;

                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>route('panelUsuario')], ['nombre'=> 'Mis pedidos','ruta'=>'']];

                return view('cliente.panelPedidos',['breadcrumb'=>$breadcrumb,'numPanel' => 3, 'tipoPedido' => $tipoPedido]);
            default:
                $breadcrumb = [['nombre'=> 'Usuario','ruta'=>'']];
                

                return view('cliente.panelInicio',['breadcrumb'=>$breadcrumb,'numPanel' => 1]);
        }
    }

    public function editarCliente(Request $request){
        $validacion = Validator::make($request->all(), array(
            'cliente-nombreCompleto' => 'nullable|string|max:45',
            'cliente-aPaterno' => 'nullable|string|max:45',
            'cliente-aMaterno' => 'nullable|string|max:45',
            'cliente-calle' => 'nullable|string|max:70',
            'cliente-entreCalle' => 'nullable|string|max:70',
            'cliente-nExt' => 'nullable|string|max:10',
            'cliente-nInt' => 'nullable|string|max:10',
            'cliente-cp' => 'nullable|string|max:12',
            'cliente-colonia' => 'nullable|string|max:50',
            'cliente-municipio' => 'nullable|string|max:70',
            'cliente-estado' =>  'nullable|string|max:50',
            'cliente-telefono' => 'nullable|string|max:15'
        ));

        if($validacion->fails()){
            return back()->with('Error' , 'No se pudo actualizar tus datos, intenta verificarlos');
        }

        $usuario = Auth::guard("cliente")->user();

        if(!$usuario){ //No hay un usuario loggeado
            return back()->with('Error' , 'No se pudo actualizar tus datos, hubo un error interno');
        }

        $usuario->nombreCompleto = ($request->has("cliente-nombreCompleto"))? $request->input("cliente-nombreCompleto"): "";
        $usuario->aPaterno = ($request->has("cliente-aPaterno"))? $request->input("cliente-aPaterno"): "";
        $usuario->aMaterno = ($request->has("cliente-aMaterno"))? $request->input("cliente-aMaterno"): "";
        $usuario->calle = ($request->has("cliente-calle"))? $request->input("cliente-calle"): "";
        $usuario->entreCalle = ($request->has("cliente-entreCalle"))? $request->input("cliente-entreCalle"): "";
        $usuario->nExt = ($request->has("cliente-nExt"))? $request->input("cliente-nExt"): "";
        $usuario->nInt = ($request->has("cliente-nInt"))? $request->input("cliente-nInt"): "";
        $usuario->cp = ($request->has("cliente-cp"))? $request->input("cliente-cp"): "";
        $usuario->colonia = ($request->has("cliente-colonia"))? $request->input("cliente-colonia"): "";
        $usuario->municipio = ($request->has("cliente-municipio"))? $request->input("cliente-municipio"): "";
        $usuario->estado = ($request->has("cliente-estado"))? $request->input("cliente-estado"): "";
        $usuario->telefono = ($request->has("cliente-telefono"))? $request->input("cliente-telefono"): "";
        $usuario->telefono = preg_replace('/[^0-9]/', '', $usuario->telefono);
        try{
            if(!$usuario->save()){ //No se logro guardar el usuario de manera correcta;
                return back()->with('Error' , 'No se pudo actualizar tus datos, hubo un error interno');
            }
        } catch (\Illuminate\Database\QueryException $e){
            return back()->with('Error' , 'No se pudo actualizar tus datos, hubo un error interno');
        }
        return redirect()->route('panelUsuario')->with('Mensaje' , 'Tus datos han sido actualizados con éxito');
    }

    public function getCarrito(){
        $carrito = session()->get('carrito');
        $total = session()->get('total');
        $envio = session()->get('envio');

        $breadcrumb = [['nombre' => 'Carrito', 'ruta'=>'']];

        return view('carrito',[
            'total' => $total,
            'carrito' => $carrito,
            'breadcrumb' => $breadcrumb,
            'envio' => $envio,
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
        $envio = (session()->get('envio'))? session()->get('envio'): 0;

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
        session()->put('envio',$envio);

        if($request->ajax()){
            $subtotal = $carrito[$codigo]['cantidad'] * $carrito[$codigo]['precio'];
            return ['codigo'=>200,'total'=>number_format($total+$envio,2),'cantidad'=>$carrito[$codigo]['cantidad'],'subtotal'=>number_format($subtotal,2),'envio'=>number_format($envio,2),'envioSF'=>$envio];
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
        $envio = (session()->get('envio'))? session()->get('envio'): 0;
 
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
            session()->put('envio',$envio);
        }
        return redirect()->route('carritoUsuario')->with('Mensaje', 'Producto eliminado correctamente!');
    }

    public function vaciarCarrito(){
        session()->forget('carrito');
        session()->forget('productos');
        session()->forget('total');
        session()->forget('envio');

        return redirect()->route('inicio');
    }

    public function getConfirmCompra(){
        $carrito = session()->get('carrito');
        $total = session()->get('total');
        $envio = session()->get('envio');

        if(!$carrito){
            return redirect()->route('carritoUsuario');
        }else if(count($carrito) <= 0){
            return redirect()->route('carritoUsuario');
        }

        $breadcrumb = [['nombre' => 'Carrito', 'ruta'=>route('carritoUsuario')], ['nombre'=>'Confirmar', 'ruta'=>'']];

        return view('confirmarCompra',[
            'total' => $total,
            'carrito' => $carrito,
            'envio' => $envio,
            'breadcrumb' => $breadcrumb,
            'sinNavbar' => true
        ]);
    }

    public function datosEnvioCliente(Request $request){ //? Trae los datos del cliente loggeado actualmente
        if(Auth::guard('cliente')->check()){
            $regreso = Auth::guard('cliente')->user()->datosEnvio;

            return $regreso;
        }
    }

    public function correo(Request $request){

        $destinatario = $request->input("correo");

        Mail::to($destinatario)->send(new CompraRealizada());
    }

    public function procesarCompra(Request $request){
        if($request->ajax()){
            date_default_timezone_set('America/Mexico_City');

            $validacion = Validator::make($request->all(), array(
                'tipoDePago' => 'required|string|max:30',
                'conektaTokenId' => 'nullable|string|max:100',
                'paypalTokenOrder' => 'nullable|string|max:100',
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
                'cliente-almacenarDir' => 'nullable|string|max:5',
                'cliente-mesesIntereses' => 'nullable|int'
            ));

            if($validacion->fails()){
                $errores = $validacion->errors();
                if(!$request->has("tipoDePago")){
                    $mensaje = "No se pudo procesar la compra, selecciona un metodo de pago";
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

            $subtotal = session()->get('total');

            if(!$subtotal){
                return array('Error', "No tienes productos en tu carrito");
            }else if($subtotal <=0){
                return array('Error', "No tienes productos en tu carrito");
            }

            $envio = session()->get('envio');

            if(!$envio){
                $envio = 0;
            }

            $total = $subtotal+$envio;
            $costoMeses = 0;

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
            $mesesSinIntereses = ($request->has("cliente-mesesIntereses"))? $request->input("cliente-mesesIntereses") : 0;
            $mesesSI = 0;
            $usuario = Auth::guard('cliente')->user(); //A este punto gracias al middleware, estoy seguro de que tengo un cliente registrado
            
            $clave1Venta = str_replace(array('-',':',' '), '',Carbon::now()->format('Y-m-d H:i:s'));
            $clave2Venta = $clave1Venta.str_random(6);
            while(Venta::where('clave',$clave2Venta)->count() > 0){
                $clave2Venta = $clave1Venta.str_random(6);
            }

            $nombreRecibidor = $nombres." ".$apePaterno." ".$apeMaterno;

            //?Voy a realizar el pago dependiendo de que tipo sea
            $tipoPago = $request->input("tipoDePago"); // "ConektaTarjeta" -> pago con tarjeta credito/debito , "Paypal" -> pago con paypal

            
            if($tipoPago != "ConektaTarjeta" && $tipoPago != "Paypal" && $tipoPago != "ConektaOXXO"){
                return array('Error', "Selecciona un metodo de pago valido");
            }

            if($tipoPago == "ConektaTarjeta" || $tipoPago == "ConektaOXXO"){
                \Conekta\Conekta::setApiKey("key_cUmxB4FJfqDe5ZZD7pJmbQ");
                \Conekta\Conekta::setApiVersion("2.0.0");

                if($tipoPago == "ConektaTarjeta"){$conektaToken = $request->input("conektaTokenId");}

                //? Obtengo el cliente del lado de conketa
                try{
                    if($tipoPago == "ConektaTarjeta"){
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
                    }else{
                        $cliente = \Conekta\Customer::create(
                            array(
                                "name" => $nombres." ".$apePaterno." ".$apeMaterno,
                                "email" => $usuario->email
                            )
                        );
                    }
                } catch (\Conekta\ProccessingError $error){ //Obtener el mensaje $error->getMessage();
                    return array('Error', "Hubo un error al procesar tus datos");
                } catch (\Conekta\ParameterValidationError $error){ //Obtener el mensaje $error->getMessage();
                    return array('Error', "Hubo un error al procesar tus datos");
                } catch (\Conekta\Handler $error){ //Obtener el mensaje $error->getMessage();
                    return array('Error', "Hubo un error al procesar tus datos");
                }
                switch($mesesSinIntereses){
                    case 1:
                        $mesesSI = 3;
                        $costoMeses = $total*0.1;
                        $total *= 1.1;
                        break;
                    case 2:
                        $mesesSI = 6;
                        $costoMeses = $total*0.1;
                        $total *= 1.1;
                        break;
                    case 3:
                        $mesesSI = 9;
                        $costoMeses = $total*0.15;
                        $total *= 1.15;
                        break;
                    case 4:
                        $mesesSI = 12;
                        $costoMeses = $total*0.15;
                        $total *= 1.15;
                        break;
                }
            }
            ///Hasta aqui tengo el token de conekta o paypal , los datos del pedido, un carrito con productos y el usuario 
            //? Cambio de los datos del cliente, en caso de que lo haya solicitado
            if($almacenarDir == "on"){ //Cambiar los datos del cliente
                $usuario->nombreCompleto = $nombres;
                $usuario->aPaterno = $apePaterno;
                $usuario->aMaterno = $apeMaterno;
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
                    if(!$usuario->save()){ //No se logro guardar el usuario de manera correcta;
                        //No pasa nada, por ahora
                    }
                } catch (\Illuminate\Database\QueryException $e){
                    //No pasa nada, por ahora //return array('Error', "No se pudo guardar la direccion del cliente");
                }
            }

            //? Registro de la orden de venta
            $venta = new Venta();
            $venta->nombreCompleto = $nombres;
            $venta->aPaterno = $apePaterno;
            $venta->aMaterno = $apeMaterno;
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
            $venta->subtotal = $subtotal;
            $venta->costo_envio = $envio;
            $venta->costo_meses = $costoMeses;
            $venta->total = $total;
            $venta->tipoPago = $tipoPago;
            $venta->clave = $clave2Venta;
            $venta->mesesSinIntereses = $mesesSI;
            try{
                if(!$venta->save()){ //No se logro guardar el producto de manera correcta;
                    return array('Error', "Hubo un error al procesar la compra");
                }
            } catch (\Illuminate\Database\QueryException $e){
                return array('Error', "Hubo un error al procesar la compra");
            }

            //? Registro de los detalles de la orden de venta
            $listaProductos = array();
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

            if($tipoPago == "ConektaTarjeta" || $tipoPago == "ConektaOXXO"){
                //? Creacion de la orden de venta de  conekta
                if($tipoPago == "ConektaTarjeta"){
                    $metodoPago = array(
                        "type" => "default"
                    );
                    $meses = "";
                    switch($mesesSinIntereses){
                        case 1:
                            $metodoPago = array(
                                "type" => "default",
                                'monthly_installments' => 3  
                            );
                            $meses = " a 3 meses sin intereses";
                            array_push($listaProductos,array("name"=>"Cargo 3 meses sin intereses","unit_price"=>(int)($subtotal*10),"quantity"=>1));
                            break;
                        case 2:
                            $metodoPago = array(
                                "type" => "default",
                                'monthly_installments' => 6  
                            );
                            $meses = " a 6 meses sin intereses";
                            array_push($listaProductos,array("name"=>"Cargo 6 meses sin intereses","unit_price"=>(int)($subtotal*10),"quantity"=>1));
                            break;
                        case 3:
                            $metodoPago = array(
                                "type" => "default",
                                'monthly_installments' => 9  
                            );
                            $meses = " a 9 meses sin intereses";
                            array_push($listaProductos,array("name"=>"Cargo 9 meses sin intereses","unit_price"=>(int)($subtotal*15),"quantity"=>1));
                            break;
                        case 4:
                            $metodoPago = array(
                                "type" => "default",
                                'monthly_installments' => 12  
                            );
                            $meses = " a 12 meses sin intereses";
                            array_push($listaProductos,array("name"=>"Cargo 12 meses sin intereses","unit_price"=>(int)($subtotal*15),"quantity"=>1));
                            break;
                    }
                }else{
                    $metodoPago = array(
                        "type" => "oxxo_cash"
                    );
                }
                $entreCalle2 = ($entreCalle == "")? array() :array("between_streets" => $entreCalle);

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
                            "receiver" => $nombreRecibidor)+$entreCalle2+array(
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
                                "payment_method" => $metodoPago
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
                if($tipoPago == "ConektaTarjeta"){ //Si el pago fue por tarjeta
                    $venta->tipoPago = "ConektaTarjeta";
                    $venta->comentarios = "Pagó con tarjeta".$meses;
                    $venta->estatus = 2;
                }else{ //Si el pago fue por OXXO
                    $venta->tipoPago = "ConektaOXXO";
                    $venta->comentarios = "Realizara el pago por medio de OXXO cash";
                    $venta->estatus = 1;
                    $venta->referOXXO = $order->charges[0]->payment_method->reference;
                    $fechaEPOCH = $order->charges[0]->payment_method->expires_at;
                    $venta->fechaExpPago = date("Y-m-d H:i:s", substr(strval($fechaEPOCH), 0, 10));
                }
                $venta->clavePago = $order->id;        
                try{
                    $venta->save();
                } catch (\Illuminate\Database\QueryException $e){}
            }else if($tipoPago == "Paypal"){
                //?Corroborar el pago por paypal
                $ordenPaypal = ($request->has("paypalTokenOrder"))? $request->input("paypalTokenOrder") : "";
                if($ordenPaypal == ""){
                    return array('Error', "No se pudo procesar tu pago de Paypal, en caso de que hayas completado la transaccion ponte en contacto con nosotros");
                }

                $clientId = getenv("CLIENT_ID");
                $clientSecret = getenv("CLIENT_SECRET");
                
                if($clientId === false || $clientSecret === false){
                    return array('Error', "Error interno, por el momento no podemos procesar pagos de Paypal, en caso de que hayas completado la transaccion ponte en contacto con nosotros");
                }
                
                $enviroment = new SandboxEnvironment($clientId, $clientSecret);

                $clientePaypal = new PayPalHttpClient($enviroment);

                $response = $clientePaypal->execute(new OrdersGetRequest($ordenPaypal));
                if($response->result->status != "COMPLETED"){
                    return array('Error', "No se pudo procesar tu pago de Paypal, en caso de que hayas completado la transaccion ponte en contacto con nosotros");
                }

                if($response->result->purchase_units[0]->amount->value != $total){
                    return array("Error", "El precio que pagaste en Paypal no coincide con el precio del carrito, contactanos para solucionarlo");
                }

                //? Llenado del estatus de la venta como pagado
                $venta->clavePago = $response->result->id;
                $venta->tipoPago = "Paypal";
                $venta->estatus = 2;
                $venta->comentarios = "Pago con paypal";
                try{
                    $venta->save();
                } catch (\Illuminate\Database\QueryException $e){}
            }

            //? Vaciado de carrito
            session()->forget('carrito');
            session()->forget('productos');
            session()->forget('total');
            session()->forget('envio');

            //? Mandar email
            ///////////////////////////////////
            
            Mail::to($usuario->email)->send(new CompraRealizada($venta));

            return array("Exito" , "La compra se realizo con exito, los detalles de la compra fueron enviados a su correo(".$usuario->email.") o puedes consultarlos en la ventana de 'Mis Pedidos' en la barra principal");
        }
    }

    public function procesarPagoOXXO(){
        date_default_timezone_set('America/Mexico_City');
        $body = @file_get_contents('php://input');
        $data = json_decode($body);
        
        $tipoEvento = $data->type; //¿Qué evento es?
        $livemode = $data->livemode; // True o false , si el evento es en modo de pruebas dara false
        
        if($tipoEvento == "order.paid" || $livemode == true){ //!!! Cambiar el "or" por un "and"
             $metodoPago = $data->data->object->charges->data[0]->payment_method->service_name;//->data[0]->payment_method->service_name; //Metodo de pago
             $statusPago = $data->data->object->payment_status; //Estado del pago, si es "paid" significa que esta pagado

             if($metodoPago == "OxxoPay" && $statusPago == "paid"){
                $cantidad = $data->data->object->amount; //Es la cantidad pagada por el usuario, multiplicada por 100
                $claveConekta = $data->data->object->id;  //Id de la orden "ord_xxxxxxxx"
                $referencia = $data->data->object->charges->data[0]->payment_method->reference;
                $fechaEPOCH = $data->data->object->charges->data[0]->paid_at; //Fecha de pago en formato UNIX
                $fechaDePago =  date("Y-m-d H:i:s", substr(strval($fechaEPOCH), 0, 10));
                
                $orden = Venta::where('clavePago', $claveConekta)->where('referOXXO', $referencia)->first();
                
                if(!$orden){
                    header('HTTP/1.1 500 Internal Server Error');
                    return array("ERROR" => "No existe un pedido con esa clave y numero de referencia","claveConekta" => $claveConekta, "referencia" => $referencia);
                }
                
                if($cantidad == $orden->total*100){
                    if($orden->estatus == 1){                    
                        $orden->estatus = 2;
                        $orden->comentarios .= ' Realizo el pago por OXXO en la fecha '.$fechaDePago;
                        try{
                            if(!$orden->save()){ //No se logro actualizar laorden de forma correcta
                                 header('HTTP/1.1 500 Internal Server Error');
                                 return array("ERROR" => "No se pudo actualizar la orden");
                            }
                        } catch (\Illuminate\Database\QueryException $e){
                            header('HTTP/1.1 500 Internal Server Error');
                            return array("ERROR" => "No se pudo actualizar la orden, error de query");
                        }
                        header('HTTP/1.1 200 OK');
                        return 1;
                        //Enviar correo de confirmación de pago;
                    }else{
                        header('HTTP/1.1 500 Internal Server Error');
                        return array("ERROR" => "El estatus de la orden ya es diferente que 'pendiente'");
                    }
                }
             }
        }
        header('HTTP/1.1 200 OK');
        return array("info" => "El evento no fue 'order.paid' o esta en modo de pruebas o el metodo no fue oxxoPay o su estatus no es 'paid'");
    }
}
