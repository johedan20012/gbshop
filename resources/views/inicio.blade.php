@extends('layouts.base')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/inicio.css')}}" type="text/css"> 
@endsection

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('contenido')
<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-4 col-sm-12 col-12 collapse navbar-collapse show" id="navbarTogglerDemo01">
            @include('widgets.sidebarCategorias')
        </div>
        <div class="col-md-8 col-sm-12 col-12">
            <hr>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $cont = 0; ?>
                    @foreach($banners as $banner)
                        @if($cont == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$cont}}" class="active"></li>
                        @else
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$cont}}"></li>
                        @endif
                        <?php $cont +=1?>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <?php $cont = 0; ?>
                    @foreach($banners as $banner)
                        <?php $banner = pathinfo($banner, PATHINFO_FILENAME); ?>
                        @if($cont == 0)
                            <div class="carousel-item active" data-id="{{$cont}}" data-nombre="{{$banner}}">
                        @else
                            <div class="carousel-item" data-id="{{$cont}}" data-nombre="{{$banner}}">
                        @endif
                                <picture>
                                    <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/banners/'.$banner.'.webp') }}">
                                    <source type="image/png" srcset = "{{asset('storage/imagenesLayout/banners/'.$banner.'.png') }}">
                                    <img src="{{asset('storage/imagenesLayout/banners/'.$banner.'.png') }}" class="d-block w-100" alt="...">
                                </picture>
                            </div>
                        <?php $cont = 1;?>
                    @endforeach 
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>  
            <hr>
            <div class="row">
                @foreach($productos as $producto)
                    <div class="col-sm-12 col-lg-6">
                        <div class="card mb-3">
                            <div class="row no-gutters">                 
                                <div class="col-md-6 col-6">
                                    <div class="card-body">
                                        <p class="card-title money">${{$producto->precio}}</p>
                                        <p class="card-text"><small>{{$producto->nombre}}</small></p>
                                        @if($producto->stock > 0)
                                            <div style="text-align: center"><a href="{{ route('verProducto').'?code='.$producto->codigo }}"class="btn btn-danger">Comprar</a></div>
                                        @else
                                            <div style="text-align: center"><a href="{{ route('verProducto').'?code='.$producto->codigo }}"class="btn btn-danger">Ver</a></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    @if($producto->stock <= 0)
                                        <picture>
                                            <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/agotado.webp') }}">
                                            <source type="image/png" srcset = "{{asset('storage/imagenesLayout/agotado.png') }}">
                                            <img src="{{asset('storage/imagenesLayout/agotado.png') }}" style="position: absolute; z-index : 2; width: 45%; top: 15%;" >
                                        </picture>
                                    @endif
                                    @if(isset($producto->foto))
                                        <?php $fotoProducto = pathinfo($producto->foto->nombre, PATHINFO_FILENAME); ?>
                                        <a href="{{ route('verProducto').'?code='.$producto->codigo }}" >
                                            <div class = "dimensiones2" style="padding:15px;">
                                                <div class = "contImgProducto">
                                                    <picture>
                                                        <source type="image/webp" srcset = "{{asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp') }}">
                                                        <source type="image/png" srcset = "{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}">
                                                        <img src="{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}" class="d-block w-100" alt="...">
                                                    </picture>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/inicio.js') }}"></script>
@endsection