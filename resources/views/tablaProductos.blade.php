<table class="table table-bordered">
    <thead>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr>
                <th>
                    <div class="search-result_container" style="padding-right: 175px;">
                        @if(isset($producto->foto))
                            <div class="search-result_image pull-left">
                                <a href="{{ route('verProducto', [$producto->idproductos]) }}">
                                    <img width="100px" height="100px" src="{{ asset('storage/imagenesProductos/'.$producto->foto->nombre) }}" alt="" title=""></a>
                                </a>
                            </div>
                        @endif
                        <h2 class="product_name ms-search-result_item-desc">
                            <a href="{{ route('verProducto', [$producto->idproductos]) }}" title="{{$producto->nombre}}" target="_self">{{$producto->nombre}}</a>
                        </h2>

                        <span class="price-item ms-price ms-search-result_item-price">
                            <div id="product_price" class="ms-vip-price-container">
                                <span class="money">$ {{ $producto->precio }}</span>
                            </div>          
                        </span>
                    </div>
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
  
{!! $productos->links() !!}