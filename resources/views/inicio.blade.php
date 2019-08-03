@extends('layouts.base')

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('contenido')
  <br><hr>
  <div class="d-flex justify-content-center">
    <div class ="row col-md-11 pl-md-2">
        <div class="col-md-4">
          <ul class="sidenav list-group">
              <li class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                      <div class="row col-md-12">
                          <div class="col-md-11 pl-md-1">
                            <a class="d-inline categoria" href="" title="Todos" target="_self" nombreCat="">Todos
                              <input type="hidden" value="0">
                            </a>
                          </div>
                      </div>
                  </div>              
              </li>
              @foreach($categorias as $categoria)
                  <li class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 justify-content-between">
                          <div class="row col-md-12">
                              <div class="col-md-11 pl-md-1">
                                <a class="d-inline categoria" href="" title="{{$categoria->nombre}}" target="_self" nombreCat="{{$categoria->nombre}}">{{$categoria->nombre}}
                                  <input type="hidden" value="{{$categoria->idcategorias}}">
                                </a>
                              </div>
                              @if(count($categoria->subCategorias) )
                                <button class="dropdown-btn  col-md-1">
                                  <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-container">
                                  @foreach($categoria->subCategorias as $subCategoria)
                                    <a class="categoria subCategoria" href="#" nombreCat="{{$categoria->nombre}}" nombreSubCat="{{$subCategoria->nombre}}" idCat="{{$categoria->idcategorias}}">{{$subCategoria->nombre}}
                                      <input type="hidden" value="{{$subCategoria->idcategorias}}">
                                    </a>
                                  @endforeach
                                </div>
                              @endif
                          </div>
                      </div>              
                  </li>
              @endforeach
          </ul>
        </div>
        <div class="col-md-8">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="directorio">
              <li class="breadcrumb-item" id="breadcrum-init"><a href="#">GB Shop Music Store</a></li>
              
              <!-- <li class="breadcrumb-item active" aria-current="page">Otros</li> -->
            </ol>
          </nav>
          <div class="col-md-12" id="paginador">
            @include('tablaProductos')
          </div>
        </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
  <input type="hidden" value="{{ route('productosPorCategoria') }}" id="rutaProductos">
@endsection
