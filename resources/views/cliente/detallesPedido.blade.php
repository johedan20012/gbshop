@extends('layouts.cliente.base')

@section('contenido')
<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-center">
            @include('widgets.breadcrumb')
        </div>
        <div class="col-md-12 m-t-10 ">
            @if($pedido != null)
                @include('correos.correoCompra')
            @else
                No se pudo encotrar el pedido con la clave proporcionada.
            @endif            
        </div>
    </div>
</div>
@endsection