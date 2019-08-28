{!! $productos->links('widgets.pagination') !!}
<ul class="list-group">
    @if(isset($actual))  
        <input type="hidden" id="categoria-actual" value="{{ $actual }}">  
    @else
        <input type="hidden" id="categoria-actual" value=""> 
    @endif
    @if(isset($actual2))  
        <input type="hidden" id="cadena-actual" value="{{ $actual2 }}">  
    @else
        <input type="hidden" id="cadena-actual" value=""> 
    @endif

    @if(count($productos) == 0)
        No se encontraron productos con los datos solicitados.
    @endif
    @foreach($productos as $producto)
        <li class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                
                <div class="image-parent">
                    @if(isset($producto->foto))
                        <a href="{{ route('verProducto').'?code='.$producto->codigo }}">
                            <img class="img-fluid" width="100px" height="100px" src="{{ asset('storage/imagenesProductos/'.$producto->foto->nombre) }}" alt="" title=""></a>
                        </a>
                    @endif
                </div>

                <div class="text-left mr-auto">
                    <a href="{{ route('verProducto').'?code='.$producto->codigo }}" title="{{$producto->nombre}}" target="_self">{{$producto->nombre}}</a>
                </div>

                <span class="price-item ms-price ms-search-result_item-price">
                    <div id="product_price" class="money">
                        <span class="money">${{ $producto->precio }}</span>
                    </div>          
                </span>
            </div>
        </li>
    @endforeach
</ul>
{!! $productos->links('widgets.pagination') !!}