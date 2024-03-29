@extends('layouts.cliente.base')

@section('css')
    @parent
    <link rel="stylesheet" href=" {{ asset('css/carrito.css')}}" type="text/css"> 
@endsection

@section('contenido')
<div class="container">
    @if(Session::has('Mensaje') || Session::has('Error'))
        <div class="toast" id="myToast" data-delay="3000" style="max-width: none;">
            <div class="toast-header">
                <strong class="mr-auto"><i class="fas fa-info-circle"></i>Mensaje de GBShop</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                @if(Session::has('Mensaje'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('Mensaje') }}
                    </div>
                @elseif(Session::has('Error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('Error') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            @include('widgets.breadcrumb')
        </div>
        <div class="col-md-8 carrito">
            <h2>Carrito de Compras</h2>
            @if($carrito !== null)
                @foreach($carrito as $producto)
                    <?php $fotoProducto = pathinfo($producto['foto'], PATHINFO_FILENAME); ?>
                    <div class="row" id="{{$loop->iteration}}listaProducto">
                        <div class="col-3 col-md-2 col-sm-2">
                            <a href="{{ route('verProducto').'?code='.$producto['codigo'] }}">
                                <picture>
                                    <source type="image/webp" srcset = "{{ asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp')}}">
                                    <source type="image/png" srcset = "{{ asset('storage/imagenesProductos/'.$fotoProducto.'.png')}}">
                                    <img src="{{ asset('storage/imagenesProductos/'.$fotoProducto.'.png')}}" class="img-fluid" alt="imagen">
                                </picture>
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
                                <div class="producto-mas">
                                <a href="#" onclick="changeProducto('{{$producto['codigo']}}', 1,{{$loop->iteration}})">+</a>
                                </div>
                                <div class="producto-menos">
                                    <a href="#" onclick="changeProducto('{{$producto['codigo']}}', -1,{{$loop->iteration}})">-</a>
                                </div>
                                <div class="producto-eliminar">
                                    <a href="{{route('delCarrito')}}?codigo={{$producto['codigo']}}">
                                        <i class="fa fa-trash"></i>
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-sm-2">
                            <span class="money2">
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
            @if(false)
            <div class="tarjetas">
                <div class="row">
                    <div class="col-sm-4">
                        <i class="fa fa-credit-card"></i>
                        <span>Paga en Meses con</span>                                
                        <div style="padding-left: 7px; padding-top: 10px;"> 
                            <img src="{{ asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')}}" width="40%">  
                            <img src="{{ asset('storage/imagenesLayout/OXXO.png')}}" width="15%">
                            <img src="{{ asset('storage/imagenesLayout/7ELEVEN.png')}}" width="13%">
                            <img src="{{ asset('storage/imagenesLayout/EXTRA.PNG')}}" width="20%">                                                          
                        </div>
                            
                        <div class="accordion" id="accordionMensualidades">                                      
                            <h5 class="mb-0">
                                <i class="fa fa-money-check-alt"></i>
                                <a data-toggle="collapse" href="#collapseTree" role="button" aria-expanded="true" aria-controls="collapseTree">                                                                                        
                                    Ver mensualidades
                                </a>
                            </h5>                                        
                            <div id="collapseTree" class="collapse" aria-labelledby="headingTree" data-parent="#accordionMensualidades">
                                <label>T. Crédito:</label>
                                <select>
                                    <option value="amex">American Express</option>
                                    <option value="master">Master Card</option>
                                    <option value="visa">Visa</option>
                                </select>  
                                <br>
                                <label>Banco:</label>
                                <select>
                                    <optgroup data-id="1" label="Hasta 1 cuotas sin interés">
                                        <option value="158" data-max-installments="1">Bancomer</option>
                                        <option value="160" data-max-installments="1">Santander</option>
                                        <option value="159" data-max-installments="1">Citibanamex</option>
                                        <option value="163" data-max-installments="1">Banorte</option>
                                        <option value="164" data-max-installments="1">HSBC</option>
                                        <option value="165" data-max-installments="1">Scotiabank</option>
                                        <option value="1022" data-max-installments="1">Banregio</option>
                                        <option value="1018" data-max-installments="1">Banco Ahorro Famsa</option>
                                        <option value="1024" data-max-installments="1">Mifel</option>
                                        <option value="1023" data-max-installments="1">Inbursa</option>
                                        <option value="1021" data-max-installments="1">Bajio</option>
                                        <option value="1020" data-max-installments="1">Ixe</option>
                                        <option value="1019" data-max-installments="1">Invex</option>
                                        <option value="1017" data-max-installments="1">Afirme</option>
                                        <option value="1039" data-max-installments="1">Banco Azteca</option>
                                        <option value="1046" data-max-installments="1">Bancoppel</option>
                                    </optgroup>
                                    <optgroup label="Otros bancos" data-id="0">
                                        <option value="other">Otro</option>
                                    </optgroup>
                                </select>
                                <label>Mensualidad:</label>
                                <select>
                                    <option value="34">1 pago de <strong class="money2">$1,850.00</strong></option>
                                    <option value="35">3 pagos de $653.61</option>
                                    <option value="36">6 pagos de $338.36</option>
                                    <option value="37">12 pagos de $182.76</option>
                                    <option value="38">18 pagos de $130.19</option>
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-8">                                
                        <div class="accordion" id="accordionCostos">                                      
                            <h5 class="mb-0">
                                <i class="fa fa-truck"></i>
                                <a data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">                                                                                        
                                    Ver costos de envío
                                </a>
                            </h5>                                        
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionCostos">
                                    <table class="envios-tabla">
                                        <thead>
                                            <tr>
                                                <th>Forma de Envío</th>
                                                <th>Costo</th>
                                                <th>Entrega Estimada</th>
                                            </tr>
                                        </thead>
                                        <tbody id="opciones">
                                            <tr>
                                                <td>
                                                    Envíos Gratis
                                                </td>
                                                <td>
                                                    <span class="texto-promo">Envío gratis</span>
                                                </td>
                                                <td>
                                                    Martes&nbsp;
                                                    <strong class="dia-entrega">27 de Agosto </strong>
                                                </td>
                                            </tr> <!--
                                            <tr>
                                                <td>
                                                    Compras inferiores a $800
                                                </td>
                                                <td>
                                                    <span class="envio-precio">$ 150.00</span>
                                                </td>
                                                <td>
                                                    Miércoles&nbsp;
                                                    <strong class="dia-entrega">28 de Agosto </strong>
                                                </td>
                                            </tr>  -->
                                            <tr>
                                                <td>
                                                    A convenir
                                                </td>
                                                <td colspan="2">
                                                    <span class="envio-precio">Acuerdas la forma de entrega del producto después de la compra.</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>                                    
                </div>
            </div>
            @endif
            <br>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between iconos">
                <div>
                    <a href="{{ route('catalogo') }}"><i class="fa fa-shopping-cart iconos"></i>      Seguir Comprando</a>
                </div>
                @if($carrito !== null)
                    <div>
                        <a href="{{ route('vaciarCarrito')}}"><i class="fa fa-trash iconos"></i>     Vaciar Carrito</a>
                    </div>
                @endif
            </div>
            <section>
                <aside class="det-comp clearfix">
                    <div class="cabecera">
                        <h1>Detalle de Compra</h1>
                    </div>
                    <div class="accordion" id="accordion-detalle">
                        <h2 class="producto-encabezado">
                            <a class="" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">                                        
                                <span class="valores-titulo-etiqueta valores-etiqueta">Total</span>
                                <span id="carrito-total" class="valores-titulo-valor valores-valor">
                                    @if(isset($total) && isset($envio))
                                        ${{ number_format($envio+$total,2) }}
                                    @endif
                                </span>
                            </a>
                        </h2>
                    </div> 
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-detalle">                                
                        @if($carrito !== null)
                            @foreach($carrito as $producto)
                                <span class="valores-etiqueta" id="{{$loop->iteration}}detalleEtiqueta">{{ $producto['nombre'] }}</span>
                                <span class="valores-valor" id="{{$loop->iteration}}detalleValor" >${{ number_format( $producto['precio']*$producto['cantidad'], 2, '.', ',') }}</span>
                            @endforeach
                            <span class="valores-etiqueta">Costo de envio</span>
                            @if($envio == 0)
                                <span class="valores-valor texto-promo" id="valorEnvio" >GRATIS</span>
                            @else
                                <span class="valores-valor" id="valorEnvio" >${{number_format($envio,2)}}</span>
                            @endif
                        @endif                      
                    </div>                         
                </aside>
                @if($carrito !== null)
                    <div class="boton-continuar">
                        <a id="continuar" href="{{route('confirmCompra')}}" class="bt btn-danger btn-lg btn-block">Continuar</a>
                    </div>
                @endif
            </section>    
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <input type="hidden" value="{{ route('addCarrito') }}" id="rutaCarrito">
    <script src="{{ asset('js/carrito.js') }}"></script>
@endsection