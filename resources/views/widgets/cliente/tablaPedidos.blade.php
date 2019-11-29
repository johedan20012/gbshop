<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $pedidos->links('widgets.pagination') !!}
    </div>
    
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Fecha creación</th>
    <th scope="col">Clave</th>
    <th scope="col">Total</th>
    <th scope="col">Estatus</th>
    <th scope="col">Detalles</th>
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
        <td>{{$pedido->total}}</td>
        <td>
            @if($pedido->estatus == 1)
                En espera del pago
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
        <td>
            <a class="dropdown-item" href="{{ route('hojaPedidoCliente') }}?clavePedido={{$pedido->clave}}" target="_blank"><i class="fas fa-eye" style="color: blue"> </i> Ver detalles</a>
        </td>
        </tr>
        <tr>
    @endforeach
    </tr>
</tbody>
</table>