@extends('layouts.cliente.base')

@section('panel')
    <h3>Bienvenido, <strong class="rojo-red" style="text-transform: uppercase;">{{ Auth::user()->nombreCompleto}}</strong></h3>
    <hr>       
@endsection