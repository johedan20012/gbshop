@extends('layouts.cliente.base')

@section('contenido')
<?php
    if(!isset($numPanel)){
        $numPanel = 1;
    }elseif($numPanel != 1 && $numPanel != 2 && $numPanel != 3){
        $numPanel = 1;
    }
?>
<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-center">
            @include('widgets.breadcrumb')
        </div>
        @if(Session::has('Mensaje') || Session::has('Error'))
            <div class="col-12 col-md-12">
                <div class="toast" id="myToast" data-delay="3000" style="max-width: none;">
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
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-2 m-t-10 text-center" style="border: 2px gray solid; border-radius:8px;"> 
            <div class="p-3 row">
                @if($numPanel != 2)
                    <a href="{{ route('panelUsuario').'?panel=2'}}">Editar información</a>
                @else
                    Editar información
                @endif
            </div>
            <hr style="margin: 0;">
            <div class="p-3 row">
                @if($numPanel != 3)
                    <a href="{{ route('panelUsuario').'?panel=3'}}">Historial de pedidos</a>
                @else
                    Historial de pedidos
                @endif
            </div>
        </div>           
        <div class="col-md-10 m-t-10 ">
            @yield('panel')                   
        </div>
    </div>
</div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function(){
            //Toast de mensaje de alert, succes o warning
            if($("#myToast") != null) $("#myToast").toast('show');
        });
    </script>
@endsection
