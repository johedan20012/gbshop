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
                    <img src="{{asset('storage/imagenesLayout/logo.png') }}"  alt="Gb Shop">
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
