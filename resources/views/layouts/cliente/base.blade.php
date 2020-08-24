@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{asset('css/cliente/base.css')}}">
@endsection

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('header')
<header class="header-tienda">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-xs-12">
                <a href="{{ route('inicio')}}">
                    <picture>
                        <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/logo.webp') }}">
                        <source type="image/png" srcset = "{{asset('storage/imagenesLayout/logo.png') }}">
                        <img src="{{asset('storage/imagenesLayout/logo.png') }}" class="img-responsive" alt="Gb Shop">
                    </picture>
                </a>
            </div>
            <div class="col-12 col-md-6 col-xs-12 text-center abajo">
                <ul class="lista-inline">
                    <br>
                    <li class="">
                        <i class="fas fa-lock rojo-red"></i>
                        Pago seguro y fácil
                    </li>
                    <li class="">
                        <i class="fas fa-shipping-fast rojo-red"></i>
                        Tu pedido en la fecha programada
                    </li>
                </ul>
            </div>
        </div>
    </div>  
</header>
@endsection
