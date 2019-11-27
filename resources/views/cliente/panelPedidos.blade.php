@extends('layouts.cliente.basePanel')

@section('panel')
    <?php
        if(!isset($tipoPedido)){
            $tipoPedido = 1;
        }elseif($tipoPedido != 1 && $tipoPedido != 2 && $tipoPedido != 3){
            $tipoPedido = 1;
        }
    ?>   
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size:medium">
        @if( $tipoPedido == 1)
            <a href = "{{route('panelUsuario').'?panel=3&type=1'}}" class="nav-item nav-link active" id="nav-productos-tab" aria-selected="true"><h6>Todos mis pedidos</h6></a>
        @else
            <a href = "{{route('panelUsuario').'?panel=3&type=1'}}" class="nav-item nav-link" id="nav-productos-tab" aria-selected="false"><h6>Todos mis pedidos</h6></a>
        @endif
        @if($tipoPedido == 2)
            <a href = "{{route('panelUsuario').'?panel=3&type=2'}}" class="nav-item nav-link active" id="nav-marcas-tab" aria-selected="true"><h6>Pedidos en curso</h6></a>
        @else
            <a href = "{{route('panelUsuario').'?panel=3&type=2'}}" class="nav-item nav-link" id="nav-marcas-tab" aria-selected="false"><h6>Pedidos en curso</h6></a>
        @endif
       
        @if($tipoPedido == 3)
            <a href = "{{route('panelUsuario').'?panel=3&type=3'}}" class="nav-item nav-link active" id="nav-admin-tab" aria-selected="true"><h6>Pedidos cancelados</h6></a>
        @else
            <a href = "{{route('panelUsuario').'?panel=3&type=3'}}" class="nav-item nav-link" id="nav-admin-tab" aria-selected="false"><h6>Pedidos cancelados</h6></a>
        @endif
    </div>
    </nav>

@endsection