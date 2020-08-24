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
            <div class="m-0 col-md-12">
                <div class="row">
                    <div class="image-parent col-md-4 col-4 pb-md-1" style="padding:0px;">
                        @if($producto->stock <= 0)
                            <img src="{{asset('storage/imagenesLayout/agotado.png') }}" style="position: absolute; z-index : 2; width: 45%;" >
                        @endif
                        @if(isset($producto->foto))
                            <?php $fotoProducto = pathinfo($producto->foto->nombre, PATHINFO_FILENAME); ?>
                            <a href="{{ route('verProducto').'?code='.$producto->codigo }}" style="height:100%; width:100%; position: absolute; left: 0px;">
                                <div class = "dimensiones2" style="padding:15px;">
                                    <div class = "contImgProducto">
                                        <picture>
                                            <source type="image/webp" srcset = "{{asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp') }}">
                                            <source type="image/png" srcset = "{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}">
                                            <img src="{{asset('storage/imagenesProductos/'.$fotoProducto.'.png') }}" class="d-block w-100" alt="...">
                                        </picture>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                    
                    <div class="text-left mr-auto col-md-8 col-8 pt-5 pb-3 pl-1 pr-1 pt-md-5 pb-md-5">
                        <a href="{{ route('verProducto').'?code='.$producto->codigo }}" title="{{$producto->nombre}}" target="_self">{{$producto->nombre}}</a>
                        <div class="row" style="padding-left:15px;">
                            @if($producto->stock > 0)
                                <label class = "">Disponibilidad:</label>
                                <span class="text-success" style="padding-left:10px;">En existencia</span> 
                            @else
                                <span class="text-danger">Producto agotado</span>                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <span class="price-item ms-price ms-search-result_item-price text-right col-md-12 col-12 pr-1 pl-1 pr-md-2">
                        <div id="product_price" class="money">
                            <span class="money">${{ $producto->precio }}</span>
                        </div>          
                    </span>
                </div>
            </div>
        </li>
    @endforeach
</ul>
{!! $productos->links('widgets.pagination') !!}