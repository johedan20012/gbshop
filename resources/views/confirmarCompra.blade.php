@extends('layouts.cliente.base')

@section('css')
    @parent
    <link rel="stylesheet" href=" {{ asset('css/confirmarCompra.css')}}" type="text/css"> 
@endsection

@section('contenido')
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('widgets.breadcrumb')
            </div>
            <div class="col-md-8 carrito">
                <div class="accordion" id="accordionGrupo">
                    <div class="card">
                        <div class="card-header" id="heading1">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                Tu carrito
                            </button>
                        </h2>
                        </div>
                        <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionGrupo">
                            <div class="card-body">
                                <h2>Tu Carrito </h2>                                       
                                @if($carrito !== null)
                                    @foreach($carrito as $producto)
                                        <div class="row" id="{{$loop->iteration}}listaProducto">
                                            <div class="col-3 col-md-2 col-sm-2">
                                                <a href="{{ route('verProducto').'?code='.$producto['codigo'] }}">
                                                    <img src="{{ asset('storage/imagenesProductos/'.$producto['foto'])}}" class="img-fluid" alt="imagen">
                                                </a>
                                            </div>
                                            <div class="col-9 col-md-4 col-sm-3">
                                                {{ $producto['nombre'] }}
                                            </div>
                                            <div class="col-8 col-md-2 col-sm-5">
                                                <div class="controles-producto">
                                                    <div class="producto-cantidad" id="{{$loop->iteration}}cantidadProducto">
                                                        {{ $producto['cantidad'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-3 col-sm-2">
                                                <span class="money2">
                                                    Precio por unidad:
                                                    ${{ number_format( $producto['precio'], 2, '.', ',') }}
                                                </span>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    <br>
                                    Por el momento no cuentas con productos en tu carrito, puedes agregar dando click <a href="{{route('catalogo')}}" class="text-primary">AQUI</a>
                                    <br>
                                @endif                             
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading2">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Datos de Envío
                                </button>
                            </h2>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionGrupo">
                            <div class="card-body">                                
                                <div class="panel-envio border border-primary rounded p-3" >
                                    <h2>Datos de envio</h2>
                                    <hr>
                                    <div class="col-12 col-md-12">
                                        <div class="toast" id="toast-envio" data-delay="3000" style="max-width:none; margin:0; width:100%;">
                                            <div class="toast-body">
                                                <div class="alert alert-danger" id="mensaje"  role="alert"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="gris-gray">Proporciona los datos de quien recibirá el pedido</span>
                                    <div class="form-group col-12 col-md-12">
                                        <input type="checkbox" class="" name="cliente-dirAlmacenada" id="cliente-dirAlmacenada" placeholder="Dirección Almacenada">
                                        <label for="cliente-dirAlmacenada">Utilizar Dirección Almacenada</label>
                                    </div>
                                    <form id="form-envio" role="form" action="{{route('procesarCompra')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-row" >
                                            <div class="form-group col-12 col-md-6">
                                                <label for="cliente-nombreCompleto">Nombre Completo<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="45" size="45" class="form-control form-envio-cliente" name="cliente-nombreCompleto" id="cliente-nombreCompleto" required >
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <label for="cliente-aPaterno">Apellido Paterno<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="45" size="45" class="form-control form-envio-cliente" name="cliente-aPaterno" id="cliente-aPaterno" required >
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <label for="cliente-aMaterno">Apellido Materno</label>
                                                <input type="text" maxlength="45" size="45" class="form-control form-envio-cliente" name="cliente-aMaterno" id="cliente-aMaterno" >
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <label for="cliente-calle">Calle<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="70" size="70" class="form-control form-envio-cliente" name="cliente-calle" id="cliente-calle" required >
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <label for="cliente-entreCalle">Entre Calle</label>
                                                <input type="text" maxlength="70" size="70" class="form-control form-envio-cliente" name="cliente-entreCalle" id="cliente-entreCalle">
                                            </div>
                                            <div class="form-group col-4 col-md-2">
                                                <label for="cliente-nExt"># Exterior<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="10" size="10" class="form-control form-envio-cliente" name="cliente-nExt" id="cliente-nExt" required>
                                            </div> 
                                            <div class="form-group col-4 col-md-2">
                                                <label for="cliente-nInt"># Interior</label>
                                                <input type="text" maxlength="10" size="10" class="form-control form-envio-cliente" name="cliente-nInt" id="cliente-nInt">
                                            </div> 
                                            <div class="form-group col-4 col-md-2">
                                                <label for="cliente-cp">C. Postal<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="12" size="12" class="form-control form-envio-cliente" name="cliente-cp" id="cliente-cp" required >
                                            </div>
                                            <div class="form-group col-6 col-md-6">
                                                <label for="cliente-colonia">Colonia<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="50" size="50" class="form-control form-envio-cliente" name="cliente-colonia" id="cliente-colonia" required >
                                            </div>
                                            <div class="form-group col-6 col-md-6">
                                                <label for="cliente-municipio">Municipio<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="70" size="70" class="form-control form-envio-cliente" name="cliente-municipio" id="cliente-municipio" required >
                                            </div> 
                                            <div class="form-group col-6 col-md-6">
                                                <label for="cliente-estado">Estado<span class="rojo-red"> *</span></label>
                                                <input type="text" maxlength="50" size="50" class="form-control form-envio-cliente" name="cliente-estado" id="cliente-estado" required >
                                            </div> 
                                            <div class="form-group col-6 col-md-6">
                                                <label for="cliente-telefono">Teléfono de contacto</label>
                                                <input type="tel" maxlength="15" size="15" class="form-control form-envio-cliente" name="cliente-telefono" id="cliente-telefono" >
                                            </div> 
                                            <div class="form-group col-12 col-md-6">
                                                <label for="cliente-referencias">Referencias del domicilio</label>
                                                <input type="text" maxlength="100" size="100" class="form-control form-envio-cliente" name="cliente-referencias" id="cliente-referencias">
                                            </div>
                                            <div class="form-group col-6 col-md-6">
                                                <input type="checkbox" class="" name="cliente-almacenarDir" id="cliente-almacenarDir">
                                                <label for="cliente-almacenarDir">Almacenar como dirección actual</label>
                                            </div>
                                            <input type="hidden" class="form-control" name="cliente-mesesIntereses" id="cliente-mesesIntereses" >
                                            <div class="form-group col-6 col-md-6">
                                                <label ><span class="rojo-red"> *</span>Campos obligatorios</label>
                                            </div>
                                        </div>                                                                    
                                    </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading3">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Método de pago
                                </button>
                            </h2>
                        </div>
                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionGrupo">
                            <div class="card-body">
                                <div class="payment" >
                                    <div class="accordion" id="accordionPago">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">                               
                                                <li >
                                                    <input data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="pm-conektaCash" type="radio" class="input-radio btn btn-link" name="payment_method" value="oxxo"  >
                                                    <label for="payment_method_ConektaCash">Conekta: Pago en Efectivo en OXXO <img src="{{ asset('storage/imagenesLayout/oxxopay.png')}}" alt="Conekta: Pago en Efectivo en OXXO" style="margin-top: -12px">	</label>
                                                </li>
                                            </div>
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPago">
                                                <div class="card-body">
                                                    Por favor realiza el pago en el OXXO más cercano utilizando la ficha de pago. Dale click en Comprar para generar la ficha de pago con codigo de barras.		                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <li >
                                                    <input  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" id="pm-conektaCard" type="radio" class="input-radio btn btn-link" name="payment_method" value="tarjeta">
                                                    <label for="payment_method_ConektaCash">Conekta: Pago seguro con tarjeta de Crédito o Débito <img src="{{ asset('storage/imagenesLayout/credits.png')}}" alt="Conekta: Pago seguro con tarjeta de Crédito o Débito">	</label>                                    
                                                </li>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionPago">
                                                <div class="col-12 col-md-12">
                                                    <div class="toast" id="toast-tarjeta" data-delay="3000" style="max-width:none; margin:0; width:100%;">
                                                        <div class="toast-body">
                                                            <div class="alert alert-danger" id="mensaje"  role="alert"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form class="" id="card-form" role="form" action="" method="post" enctype="multipart/form-data">
                                                        <span class="card-errors"></span>
                                                        <div class="form-row">
                                                            <div class="form group col-12">
                                                                <label for="card-name">Nombre del Tarjetahabiente<span class="rojo-red"> *</span></label>
                                                                <input type="text" class="form-control " aria-describedby="card-nameHelpInline" name="card-name" id="card-name" autocomplete="off" maxlength="20" required size="20">
                                                                <small id="card-nameHelpInline" class="text-muted">
                                                                    Nombre completo del titular de la tarjeta
                                                                </small>
                                                            </div>
                                                            <div class="form group mt-3 col-8 col-sm-10">
                                                                <label for="card-number">Número de Tarjeta<span class="rojo-red"> *</span></label>
                                                                <input type="text" class="form-control" aria-describedby="card-numberHelpInline" name="card-number" id="card-number" autocomplete="off" maxlength="20" required size="20">
                                                                <li class="far fa-credit-card tarjeta"></li>
                                                                <small id="card-numberHelpInline" class="text-muted mr-3">
                                                                    Número de Tarjeta válido
                                                                </small>
                                                            </div>   
                                                            <div class="form group mt-3 col-4 col-sm-2">
                                                                <label for="card-cvc" >CVC<span class="rojo-red"> *</span></label>
                                                                <input type="text" class="form-control" aria-describedby="card-cvcHelpInline" name="card-cvc" id="card-cvc" autocomplete="off" maxlength="4" required size="4">
                                                                <small id="card-cvcHelpInline" class="text-muted mr-5">
                                                                    <a href="#" class="" data-toggle="modal" data-target="#modalCvc">¿Dónde encontrarlo?</a>
                                                                </small>
                                                            </div> 
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form group mt-3 col-4 ">
                                                                <label for="card-monthExp">Mes de Expiración<span class="rojo-red"> *</span></label>  
                                                                <select class="form-control custom-select" aria-describedby="card-monthExpHelpInline" name="card-monthExp" id="card-monthExp" autocomplete="off" required>
                                                                    <option selected value="0">Selecciona un mes...</option>
                                                                    <option value="1">01 - Enero</option>
                                                                    <option value="2">02 - Febrero</option>
                                                                    <option value="3">03 - Marzo</option>
                                                                    <option value="4">04 - Abril</option>
                                                                    <option value="5">05 - Mayo</option>
                                                                    <option value="6">06 - Junio</option>
                                                                    <option value="7">07 - Julio</option>
                                                                    <option value="8">08 - Agosto</option>
                                                                    <option value="9">09 - Septiembre</option>
                                                                    <option value="10">10 - Octubre</option>
                                                                    <option value="11">11 - Noviembre</option>
                                                                    <option value="12">12 - Diciembre</option>
                                                                </select>
                                                                <small id="card-monthExpHelpInline" class="text-muted">
                                                                    Mes de expiración
                                                                </small>
                                                            </div>
                                                            <div class="form group mt-3 col-4 " >
                                                                <label for="card-yearExp">Año de Expiración<span class="rojo-red"> *</span></label> 
                                                                <input type="text" class="form-control" aria-describedby="card-yearExpHelpInline" name="card-yearExp" id="card-yearExp" autocomplete="off" maxlength="4" required size="4">
                                                                <small id="card-yearExpHelpInline" class="text-muted">
                                                                    Año de expiración
                                                                </small>
                                                            </div> 
                                                            <div class="form group mt-3 col-4 ">
                                                                <label for="card-mesesIntereses">Meses sin intereses</label>  
                                                                <select class="form-control custom-select" aria-describedby="card-mesesInteresesHelp" name="card-mesesIntereses" id="card-mesesIntereses" autocomplete="off">
                                                                    <option selected value="0">Ninguno...</option>
                                                                    <option value="1">3 Meses(Min $300)</option>
                                                                    <option value="2">6 Meses(Min $600)</option>
                                                                    <option value="3">9 Meses(Min $900)</option>
                                                                    <option value="4">12 Meses(Min $1200)</option>
                                                                </select>
                                                                <small id="card-mesesInteresesHelp" class="text-muted">
                                                                    *Aplican cargos correspondientes
                                                                </small>
                                                            </div>
                                                        </div>                                                                                                                               
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingOne">                               
                                                <li >
                                                    <input data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" id="pm-paypal" type="radio" class="input-radio btn btn-link" name="payment_method" value="paypal"  >
                                                    <label for="payment_paypal">Pago con cuenta PayPal <img src="{{ asset('storage/imagenesLayout/paypal.png')}}" style="width:100px;" alt="Pago con cuenta PayPal" style="margin-top: -12px">	</label>
                                                </li>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPago">
                                                <div class="card-body">
                                                <div id="paypal-button-container"></div>		                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                    </div>
                    <div class="boton-continuar">
                        <button id="continuarCompra" onclick="procesarCompra();" class="bt btn-danger btn-lg btn-block">Comprar</button>
                    </div>
                </div>
            </div>                                                   
            <div class="col-md-4 panel panel-default">
                <div class="d-flex justify-content-between iconos">
                    <div>
                        <a href="{{route('catalogo')}}"><i class="fa fa-shopping-cart iconos"></i>      Seguir Comprando</a>
                    </div>
                </div>
                <section>
                    <aside class="det-comp clearfix">
                        <div class="cabecera">
                            <h1>Detalle de Compra</h1>
                        </div>
                        <div class="accordion" id="accordion-detalle">
                            <h2 class="producto-encabezado">
                                <a class="" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="true" aria-controls="collapseThree">                                        
                                    <span class="valores-titulo-etiqueta valores-etiqueta">Total a pagar</span>
                                    <span id="producto-precio" class="valores-titulo-valor valores-valor">
                                        @if(isset($total) && isset($envio))
                                            ${{ number_format($total+$envio,2) }}
                                        @endif
                                    </span>
                                    @if(isset($total) && isset($envio))
                                        <input type="hidden" id="total-compra-sf" value="{{$total+$envio}}">
                                        <input type="hidden" id="total-compra" value="{{number_format($total+$envio,2)}}">
                                        <input type="hidden" id="total-compra-10" value="{{number_format(($total+$envio)*1.1,2)}}">
                                        <input type="hidden" id="aumento-compra-10" value="{{number_format(($total+$envio)*0.1,2)}}">
                                        <input type="hidden" id="total-compra-15" value="{{number_format(($total+$envio)*1.15,2)}}">
                                        <input type="hidden" id="aumento-compra-15" value="{{number_format(($total+$envio)*0.15,2)}}">
                                    @endif
                                </a>
                            </h2>
                        </div> 
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-detalle">                                
                            @if(isset($carrito))
                                @foreach($carrito as $producto)
                                    <span class="valores-etiqueta" id="{{$loop->iteration}}detalleEtiqueta">{{ $producto['nombre'] }}</span>
                                    <span class="valores-valor" id="{{$loop->iteration}}detalleValor" >${{ number_format( $producto['precio']*$producto['cantidad'], 2, '.', ',') }}</span>
                                @endforeach
                                <span class="valores-etiqueta" style="display: none;" id="mesesDetalleEtiqueta">Meses sin intereses</span>
                                <span class="valores-valor"style="display: none;"  id="mesesDetalleValor" ></span>
                                <span class="valores-etiqueta">Costo de envio</span>
                                @if($envio == 0)
                                    <span class="valores-valor texto-promo" id="valorEnvio" >GRATIS</span>
                                @else
                                    <span class="valores-valor" id="valorEnvio" >${{number_format($envio,2)}}</span>
                                @endif
                            @endif                      
                        </div>                         
                    </aside>
                    
                </section>    
            </div>
        </div>
    </div>
</div>

<!--Modales-->

<!-- Modal CVV -->
<div class="modal fade" id="modalCvc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visa / American Express</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <img class="mx-auto d-block" src="{{ asset('storage/imagenesLayout/cvv-cards.png')}}">
        </div>
        </div>
    </div>
</div>

<!-- Modal mensaje tienda -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMensajeLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="imgOk" class="text-center">
            <img src="{{ asset('storage/imagenesLayout/ok.jpg') }}"  style="width:20%;" title="Todo bien">
        </div>
        <div id="imgError" class="text-center">
            <img src="{{ asset('storage/imagenesLayout/error.png') }}"  style="width:20%;" title="Algo malo ocurrio">
        </div>
        <div id="modal-mensaje" class="col-md-12 col-12">
        
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="modal-boton1" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="modal-boton2" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <input type="hidden" value="{{ route('datosEnvio') }}" id="rutaDatosEnvio">
    <script src="{{ asset('js/confirmarCompra.js') }}"></script>
    <script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=Ac6HOuvFbi5fFO3mTxSxcThAWFu3KG0GKXzAbY0HeuHSwZcIzmY6D7YwWILwzlqgXXk7EfnUXXG6CHhy&disable-card=visa,mastercard,amex,discover,jcb,elo,hiper&currency=MXN"></script>
@endsection