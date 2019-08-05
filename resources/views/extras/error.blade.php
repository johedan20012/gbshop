@extends('layouts.base')

@section('titulo')
Error
@endsection

@section('contenido')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title">
            @foreach( $errors->all() as $message )
                <li>{{ $message }}</li>
            @endforeach
            <a href="{{ route('catalogo')}}">Volver al Inicio</a>
        </div>
    </div>
</div>
@endsection