@extends('layouts.base')

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('contenido')
  <br><hr>
  <div class="d-flex justify-content-center">
    <div class ="row col-md-11 pl-md-2">
        <div class="col-md-3">
          <ul class="list-group">
              @foreach($categorias as $categoria)
                  <li class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 justify-content-between">

                          <div class="text-left mr-auto">
                              <a href="" title="{{$categoria->nombre}}" target="_self">{{$categoria->nombre}}</a>
                          </div>
                      </div>              
                  </li>
              @endforeach
          </ul>
        </div>
        <div class="col-md-3" id="paginador">
          @include('tablaProductos')
        </div>
        <div class="col-md-6">
          <ul class="sidenav list-group">
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <div class="text-left mr-auto">
                    <a href="" title="h" target="_self">Nombre</a>
                </div>
              </div>   
            </li>
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <div class="text-left mr-auto">
                    <a href="" title="h" target="_self">Categoria2</a>
                </div>
              </div>   
            </li>
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <div class="text-left mr-auto">
                    <a href="" title="h" target="_self">Categoria3</a>
                </div>
              </div>   
            </li>
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <div class="text-left mr-auto">
                    <a href="" title="h" target="_self">Categoria4</a>
                    <button class="dropdown-btn">
                      <i class="fa fa-caret-down"></i>
                      
                    </button>
                    <h1>My Icons <i class="fa fa-pagelines"></i></h1>
                    <div class="dropdown-container">
                      <a href="#">Link 1</a>
                      <a href="#">Link 2</a>
                      <a href="#">Link 3</a>
                      </div>
                </div>
              </div>   
            </li>
            
          </div>
        </ul>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
@endsection
