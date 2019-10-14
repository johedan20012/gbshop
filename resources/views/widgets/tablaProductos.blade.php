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
        <li class="list-group-item list-group-item-action flex-column align-items-start" style="padding: 0">
            <div class="d-flex w-100 justify-content-between">
                
                <div class="image-parent col-md-2 col-2" style="padding:5px;">
                    @if(isset($producto->foto))
                        <a href="{{ route('verProducto').'?code='.$producto->codigo }}" style="height:100%; width:100%;">
                            <div style="height:100%; width:100%;">
                                <div class="dimensiones2" style="background: url({{ asset('storage/imagenesProductos/'.$producto->foto->nombre) }}) no-repeat  center; background-size: contain;"> </div>
                            </div>
                        </a>
                    @endif
                </div>

                <div class="text-left mr-auto col-md-8 col-8 pr-1 pt-4 pb-4 pl-1 p-m-6">
                    <a href="{{ route('verProducto').'?code='.$producto->codigo }}" title="{{$producto->nombre}}" target="_self">{{$producto->nombre}}</a>
                </div>

                <span class="price-item ms-price ms-search-result_item-price col-md-2 col-2 pb-4 pt-4 pr-1 pl-1 p-md-2">
                    <div id="product_price" class="money">
                        <span class="money">${{ $producto->precio }}</span>
                    </div>          
                </span>
            </div>
        </li>
    @endforeach
</ul>
{!! $productos->links('widgets.pagination') !!}