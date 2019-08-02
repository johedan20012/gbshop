@extends('layouts.base')

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('contenido')
  <div class="container" id="paginador">
    @include('tablaProductos')
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
@endsection
