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
              @foreach($categorias as $categoria)
                  <li class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 justify-content-between">
                          <div class="row col-md-12">
                              <div class="col-md-11 pl-md-1">
                                <a class="d-inline categoria" href="" title="{{$categoria->nombre}}" target="_self">{{$categoria->nombre}}</a>
                              </div>
                              @if(count($categoria->subCategorias) )
                                <button class="dropdown-btn  col-md-1">
                                  <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-container">
                                  @foreach($categoria->subCategorias as $subCategoria)
                                    <a class="categoria" href="#">{{$subCategoria->nombre}}</a>
                                  @endforeach
                                </div>
                              @endif
                          </div>
                      </div>              
                  </li>
              @endforeach
          </ul>
        </div>
        <div class="col-md-8" id="paginador">
          @include('tablaProductos')
        </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
@endsection
