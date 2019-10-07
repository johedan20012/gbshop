@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{asset('css/cliente/panel.css')}}">
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


@section('contenido')


<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-cente">
            @include('widgets.breadcrumb')
        </div>
        <div class="col-md-3 m-t-10 text-center">
            <div class="m-t-10"><a href="{{ route('panelUsuario').'?panel=2'}}">Editar información</a></div><br>
            <div class="m-t-10 m-b-20">Historial de compras</div>
        </div>           
        <div class="col-md-9 m-t-10 ">
            @yield('panel')                   
        </div>
        <div class="col-md-12">
            
                
        </div>
    </div>
</div>
@endsection
