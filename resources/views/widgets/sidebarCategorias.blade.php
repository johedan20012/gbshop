@if(isset($categorias) && $categorias != null)
    @foreach($categorias as $categoria)
        <li class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <div class="row col-md-12">
                    <div class="col-md-11 pl-md-1">
                    <a class="d-inline categoria" href="{{route('catalogo').'?id='.$categoria->idcategorias }}" title="{{$categoria->nombre}}" target="_self" nombreCat="{{$categoria->nombre}}">{{$categoria->nombre}}
                        <input type="hidden" value="{{$categoria->idcategorias}}">
                    </a>
                    </div>
                    @if(count($categoria->subCategorias) )
                    <button class="dropdown-btn  col-md-1">
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-container">
                        @foreach($categoria->subCategorias as $subCategoria)
                        <a class="categoria subCategoria" href="{{route('catalogo').'?id='.$subCategoria->idcategorias }} " nombreCat="{{$categoria->nombre}}" nombreSubCat="{{$subCategoria->nombre}}" idCat="{{$categoria->idcategorias}}">{{$subCategoria->nombre}}
                            <input type="hidden" value="{{$subCategoria->idcategorias}}">
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>              
        </li>
    @endforeach
@endif