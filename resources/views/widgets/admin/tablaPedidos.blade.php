<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $pedidos->links('widgets.pagination') !!}
    </div>

    <form class="form-inline mr-3" id="buscarPedido" action="">          
        @if(isset($actual))  
            <input type="search" class="form-group" name="pedido-busca" id="pedido-busca" placeholder="Buscar" value="{{ $actual }}"> 
        @else
            <input type="search" class="form-group" name="pedido-busca" id="pedido-busca" placeholder="Buscar"> 
        @endif            
                               
        <i class="fa fa-search"></i>
    </form>

    @if(isset($actual))  
        <input type="hidden" id="pedido-actual" value="{{ $actual }}">  
    @else
        <input type="hidden" id="pedido-actual" value=""> 
    @endif
    
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Fecha creación</th>
    <th scope="col">Clave</th>
    <th scope="col">Subtotal</th>
    <th scope="col">Costo envio</th>
    <th scope="col">Costo meses</th>
    <th scope="col">Total</th>
    <th scope="col">Estatus</th>
    <th scope="col">Comentarios</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    @if(count($pedidos) == 0)
        No se encontraron pedidos con los datos solicitados.
    @endif

    @foreach($pedidos as $pedido)
        <td>{{$pedido->created_at}}</td>
        <td class="pedido-clave">{{$pedido->clave}}</td>
        <td>{{$pedido->subtotal}}</td>
        <td>{{$pedido->costo_envio}}</td>
        <td>{{$pedido->costo_meses}}</td>
        <td>{{$pedido->total}}</td>
        <td>
            @if($pedido->estatus == 1)
                Pendiente
            @elseif($pedido->estatus == 2)
                Pagado
            @elseif($pedido->estatus == 3)
                En proceso de envio
            @elseif($pedido->estatus == 4)
                Enviado
            @else
                Cancelado
            @endif
        </td>
        <td><textarea rows="3" cols="10" disabled>{{$pedido->comentarios}}</textarea></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalPedidos" data-clave="{{$pedido->clave}}" data-type="1" data-estatus="{{$pedido->estatus}}"><i class="fa fa-edit" style="color:blue"> </i> Modificar estatus</button>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('hojaPedido') }}?clavePedido={{$pedido->clave}}&ver=1" target="_blank"><i class="fas fa-search" style="color: blue"> </i> Ver detalles</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('hojaPedido') }}?clavePedido={{$pedido->clave}}"><i class="fas fa-file-download" style="color: blue"> </i> Descargar hoja de pedido</a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalPedidos" data-clave="{{$pedido->clave}}" data-type="3"><i class="fas fa-redo-alt" style="color: blue"> </i> Reenviar correo</button>
            </div>
            </div>
        </td>
        </tr>
        <tr>
    @endforeach
    </tr>
</tbody>
</table>

<!--Modales-->

<div class="modal fade" id="modalPedidos" tabindex="-1" role="dialog" aria-labelledby="modalPedidosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalPedidosLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
        </div>    
        <div class="modal-footer">
            <button type="button" id="modal-boton1" class="btn btn-secondary" data-dismiss="modal"></button>
            <button type="button" id="modal-boton2" onclick="procesarModal($('#modalPedidos'));"class="btn btn-primary"></button>
        </div>
        <input type="hidden" id="modal-tipo">
        <input type="hidden" id="modal-clave">
    </div>
  </div>
</div>