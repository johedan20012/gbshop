@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-pedidos" role="tabpanel" aria-labelledby="nav-pedidos-tab ">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <br>
            <div id="del-pedido">
                <div id="del-pedido-form">
                    @include("widgets.admin.tablaPedidos")
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
    <input type="hidden" value="{{ route('tablaPedidos') }}" id="rutaPedidos">
    <input type="hidden" value="{{ route('editEstatusPedido') }}" id="rutaEditarEstatus">
    <input type="hidden" value="{{ route('reenviarCorreo') }}" id="rutaReenviarCorreo">
    <script src="{{ asset('js/admin/tabPedidos.js') }}"></script>
@endsection