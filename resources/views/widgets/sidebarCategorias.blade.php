<ul class="sidenav list-group">
    <li class="list-group-item list-group-item-action list-group-item-secondary flex-column align-items-start" style="background: black; border: 1px solid lightgray;">
        <div class="d-flex w-100 justify-content-between">
            <div class="row col-md-12 pl-1">
                <div class="col-md-11 pl-md-1 col-11 pl-1">
                    <a class="text-uppercase d-inline pl-0 categoria text-white" style="FONT-WEIGHT: BOLDER;" href="{{route('catalogo')}}" title="Todos" target="_self" nombreCat="">Todos
                        <input type="hidden" value="0">
                    </a>
                </div>
            </div>
        </div>              
    </li>
    @if(isset($categorias) && $categorias != null)
        @foreach($categorias as $categoria)
            <li class="list-group-item list-group-item-action list-group-item-secondary flex-column align-items-start" style="background: black; border: 1px solid lightgray;">
                <div class="d-flex w-100 justify-content-between">
                    <div class="row col-md-12 pl-1">
                        <div class="col-md-11 pl-md-1 col-11 pl-1">
                            <a class="text-uppercase d-inline pl-0 list-group-item-secondary text-white categoria" style="FONT-WEIGHT: BOLDER;" href="{{route('catalogo').'?id='.$categoria->idcategorias }}" title="{{$categoria->nombre}}" target="_self" nombreCat="{{$categoria->nombre}}">{{$categoria->nombre}}
                                <input type="hidden" value="{{$categoria->idcategorias}}">
                            </a>
                        </div>
                        @if(count($categoria->subCategorias) )
                        <button class="dropdown-btn pl-md-2 pr-md-2 col-md-1 col-1 pl-2 pr-2">
                            <i class="fa fa-caret-down" style="color: #dc3545;"></i>
                        </button>
                        <div class="dropdown-container">
                            @foreach($categoria->subCategorias as $subCategoria)
                            <a class="categoria subCategoria text-white" href="{{route('catalogo').'?id='.$subCategoria->idcategorias }} " nombreCat="{{$categoria->nombre}}" nombreSubCat="{{$subCategoria->nombre}}" idCat="{{$categoria->idcategorias}}">{{$subCategoria->nombre}}
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
</ul>