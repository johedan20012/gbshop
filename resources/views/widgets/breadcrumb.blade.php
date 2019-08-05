<nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="directorio">
        <li class="breadcrumb-item" id="breadcrum-init"><a href="{{ route('catalogo') }}">GB Shop Music Store</a></li>
        
        @if(isset($breadcrumb) && $breadcrumb != null)
            @foreach($breadcrumb as $hoja)
                @if($hoja['ruta'] == "")
                    <li class="breadcrumb-item active" id="last-categoria" aria-current="page">{{ $hoja['nombre'] }}</li>
                @else
                    <li class="breadcrumb-item" id="breadcrum-init"><a href="{{ $hoja['ruta'] }}">{{ $hoja['nombre'] }}</a></li>
                @endif
            @endforeach
            <!-- <li class="breadcrumb-item active" aria-current="page">Otros</li> -->
        @endif
    </ol>
</nav>