@extends('layouts.base')

@section('css')
<link rel="stylesheet" href=" {{ asset('css/auth/login.css')}}" type="text/css">
@endsection

@section('titulo')
Login - Admins
@endsection

@section('contenido')
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h1 style="color:#c5171f"><i class="fa fa-user"></i></h1>
        </div>

        @if(Session::has('Error'))
            <p class="text-danger">{{ Session::get('Error') }}</p>
        @endif

        <!-- Login Form -->
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <input type="text" id="user" class="fadeIn second" name="username" placeholder="Usuario" autocomplete="off" value="{{old('username')}}">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña" autocomplete="new-password">

            <label>
                <input type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}"> Recuerdame
            </label>

            <input type="submit" id="iniciar" class="fadeIn fourth" value="Iniciar Sesión">
        </form>
        
        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#" onclick="alert('favor de pasar con Gerry, jajajaja')">¿Olvidaste usuario y/o contraseña?</a>
        </div>

    </div>
</div>
@endsection