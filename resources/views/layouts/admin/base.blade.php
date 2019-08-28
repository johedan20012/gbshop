@extends('layouts.base')

@section('titulo')
Administración gbshop
@endsection

@section('css')
<link rel="stylesheet" href=" {{ asset('css/auth/admin.css')}}" type="text/css">
@endsection

@section('contenido')
<?php
    if(!isset($numPag)){
        $numPag = 5;
    }elseif($numPag != 1 && $numPag != 2 && $numPag != 3 && $numPag != 4){
        $numPag = 5;
    }
    
?>

<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-12 col-sm-12 col-12">
        <br>
        @if(Session::has('Mensaje') || Session::has('Error') || Session::has('Warning'))
            <div class="toast" id="myToast" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fa fa-grav"></i>Mensaje de GBShop</strong>
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
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size:medium">
            @if( $numPag == 1 || $numPag == 5 )
                <a href = "{{route('admin').'?panel=1'}}" class="nav-item nav-link active" id="nav-productos-tab" aria-selected="true">Productos</a>
            @else
                <a href = "{{route('admin').'?panel=1'}}" class="nav-item nav-link" id="nav-productos-tab" aria-selected="false">Productos</a>
            @endif
            @if($numPag == 2)
                <a href = "{{route('admin').'?panel=2'}}" class="nav-item nav-link active" id="nav-marcas-tab" aria-selected="true">Marcas</a>
            @else
                <a href = "{{route('admin').'?panel=2'}}" class="nav-item nav-link" id="nav-marcas-tab" aria-selected="false">Marcas</a>
            @endif
            @if($numPag == 3)
                <a href = "{{route('admin').'?panel=3'}}" class="nav-item nav-link active" id="nav-categorias-tab" aria-selected="true">Categorias</a>
            @else
                <a href = "{{route('admin').'?panel=3'}}" class="nav-item nav-link" id="nav-categorias-tab" aria-selected="false">Categorias</a>
            @endif
            @if($numPag == 4)
                <a href = "{{route('admin').'?panel=4'}}" class="nav-item nav-link active" id="nav-admin-tab" aria-selected="true">Admin</a>
            @else
                <a href = "{{route('admin').'?panel=4'}}" class="nav-item nav-link" id="nav-admin-tab" aria-selected="false">Admin</a>
            @endif
            <a class="nav-item nav-link ml-auto" role = "tab" aria-controls="nav-admin" aria-selected="false" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @yield('nav-tab');
        </div>
        
        </div>    
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/admin.js') }}"></script>
@endsection