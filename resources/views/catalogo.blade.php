@extends('layouts.base')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/catalogo.css')}}" type="text/css"> 
@endsection

@section('titulo')
  @if(isset($breadcrumb) && $breadcrumb != null)
    <?php $titulo=""?>
    @foreach($breadcrumb as $hoja)
      <?php $titulo .= ' '.$hoja['nombre']?>
    @endforeach
    {{$titulo}} | GB Route Music Store: Tienda online
  @else
    Catalogo | GB Route Music Store: Tienda online
  @endif
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
              @include('widgets.sidebarCategorias')
          </ul>
        </div>
        <div class="col-md-8">
          <div class="col-md-12" id="breadcr">
            @include('widgets.breadcrumb')
          </div>
          <div class="col-md-12" id="paginador">
            @include('widgets.tablaProductos')
          </div>
        </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
  <input type="hidden" value="{{ route('catalogo') }}" id="rutaProductos">
@endsection
