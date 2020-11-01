@extends('layouts.base')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/producto.css')}}" type="text/css">
@endsection

@section('titulo')
{{ $producto->nombre }}| GB Route Music Store: Tienda online
@endsection

@section('contenido')
<div class="container">
    @if(Session::has('Mensaje') || Session::has('Error') || Session::has('Warning'))
        <div class="toast" id="myToast" data-delay="6000" style="max-width: none;">
            <div class="toast-header">
                <strong class="mr-auto"><i class="fas fa-info-circle"></i>Mensaje de GBRoute</strong>
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
                @elseif(Session::has('Warning'))
                <div class="alert alert-warning" role="alert">
                        {{ Session::get('Warning') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    <div class="product_wrap">
        @include('widgets.breadcrumb')
        <div class="row">
        <div id="product_image_container" class="col-md-6">
            
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @if($producto->stock <= 0)
                        <picture>
                            <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/agotado.webp') }}">
                            <source type="image/png" srcset = "{{asset('storage/imagenesLayout/agotado.png') }}">
                            <img src="{{asset('storage/imagenesLayout/agotado.png') }}" style="position: absolute; z-index : 2; width: 40%;" >
                        </picture>
                    @endif
                    <?php $iteracion = 0; $bandera = 0;?>
                    @foreach($producto->fotos as $foto)
                        <?php $fotoProducto = pathinfo($foto->nombre, PATHINFO_FILENAME); ?>
                        @if($bandera == 0)
                            <div class="carousel-item active dimensiones">
                        @else
                            <div class="carousel-item dimensiones">
                        @endif
                                <picture>
                                    <source type="image/webp" srcset = "{{asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp') }}">
                                    <source type="image/png" srcset = "{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}">
                                    <img src="{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}" class="d-block imagenCarrusel" alt="...">
                                </picture>
                            </div>
                        <?php $iteracion += 1; $bandera = 1;?>
                    @endforeach
                </div>
                <a class="carousel-control-prev controlCarrusel" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next controlCarrusel" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
                <div class="row">
                    <?php $iteracion = 0;?>
                    @foreach($producto->fotos as $foto)
                        <?php $fotoProducto = pathinfo($foto->nombre, PATHINFO_FILENAME); ?>
                        <div class="col-md-3 col-sm-2 col-3">
                            <a href="#" data-target="#carouselExampleIndicators" data-slide-to="{{ $iteracion }}" class="active">
                                <div class="dimensiones-mini">
                                    <picture>
                                        <source type="image/webp" srcset = "{{asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp') }}">
                                        <source type="image/png" srcset = "{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}">
                                        <img src="{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}" class="d-block imagenCarrusel" alt="...">
                                    </picture>
                                </div>
                            </a>
                        </div>
                        <?php $iteracion += 1;?>
                    @endforeach
                </div>
        </div>
        
        <div class="col-md-6">
            <h7>{{ $producto->nombre }}</h7>
            <br>
            <h7 id="producto-marca" >{{ $producto->marca->nombre }}</h7>
            <div id="product_price" >
                <!-- sin descuento -->
                <span class="money">
                    $ {{$producto->precio}}
                </span>
                <br><br>
            </div>
            <i class="fa fa-credit-card" style="font-size: 34px;"></i>
            <span>Paga en Meses con</span>
            <br>
            <div style="padding-left: 40px; padding-top: 10px;"> 
                <picture>
                    <source type="image/webp" srcset = "{{ asset('storage/imagenesLayout/webp/visa-american-express-mastercard.webp')}}">
                    <source type="image/png" srcset = "{{ asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')}}">
                    <img src="{{ asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')}}" width="30%">  
                </picture>
                <picture>
                    <source type="image/webp" srcset = "{{ asset('storage/imagenesLayout/webp/OXXO.webp')}}">
                    <source type="image/png" srcset = "{{ asset('storage/imagenesLayout/OXXO.png')}}">
                    <img src="{{ asset('storage/imagenesLayout/OXXO.png')}}" width="10%">
                </picture>
                <!--<img src="{{ asset('storage/imagenesLayout/7ELEVEN.png')}}" width="7%"> -->
                <!--<img src="{{ asset('storage/imagenesLayout/EXTRA.PNG')}}" width="17%">  -->                        
            </div>
            <br>
            <div class="accordion" id="accordionCostos">                                      
                <h5 class="mb-0">
                    <i class="fa fa-truck"></i>
                    <span data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">                                                                                        
                        Costo de envío en la Republica Mexicana <span class="texto-promo">(Envío gratis)</span>
                    </span>
                </h5>   
            </div>
            <br>
            @if($producto->stock > 0)
                <label class = "">Disponibilidad:</label>
                <span class="text-success">En existencia</span> 

                <form action="{{ route('addCarrito') }}" enctype="multipart/form-data" role="form" method="post">
                    {{ csrf_field() }}
                    <span>Cantidad: <input min="1" type="number" name="cantidad" value="1" style="width:60px; height:27px; text-align: center;margin: 5px 10px;"></span>
                    <br><br><br>
                    <input type="hidden" value="{{ $producto->codigo}}" name="codigo">
                    <button type="submit" class="btn btn-danger">COMPRAR <i class="fa fa-shopping-cart"></i></button>
                </form>
            @else
                <span class="text-danger">Producto agotado</span>                
            @endif
        </div>
        <div id="descripcion" class="col-md-12 clear">
            {{$producto->descripcion}}
            @if($producto->atributos != "")
            <div class="row esp-producto-contenedor col-md-12">
                <header class="esp-producto-header">
                    <h4>Especificaciones del producto</h4>
                </header>
                <section class="esp-producto-section">
                    <?php $AtributosProducto = json_decode($producto->atributos);?>
                    @if($AtributosProducto)
                    @foreach($AtributosProducto as $nombre=>$valor)
                        <div class="row">
                            <div class="col-sm-4">{{$nombre}}</div>
                            <div class="col-sm-8" >{{$valor}}</div>
                        </div>
                    @endforeach
                    @endif
                </section>   
            </div>
            @endif
        </div>
        </div> 
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/producto.js') }}"></script>
@endsection