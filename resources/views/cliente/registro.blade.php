@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{asset('css/cliente/registro.css')}}">
@endsection

@section('titulo')
GB Route Music Store: Tienda online
@endsection

@section('header')
<header class="header-tienda">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-xs-12">
                <a href="{{ route('inicio')}}">
                    <picture>
                        <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/logo.webp') }}">
                        <source type="image/png" srcset = "{{asset('storage/imagenesLayout/logo.png') }}"> 
                        <img src="{{asset('storage/imagenesLayout/logo.png') }}"  alt="Gb Shop">
                    </picture>
                </a>
            </div>
            <div class="col-12 col-md-6 col-xs-12 text-center abajo">
                <ul class="lista-inline">
                    <br>
                    <li class="">
                        <i class="fas fa-lock rojo-red"></i>
                        Pago seguro y fácil
                    </li>
                    <li class="">
                        <i class="fas fa-shipping-fast rojo-red"></i>
                        Tu pedido en la fecha programada
                    </li>
                </ul>
            </div>
        </div>
    </div>  
</header>
@endsection

@section('contenido')
<div class="container">
    <div class="row">
        @if(Session::has('Error') | Session::has('Mensaje'))
            <div class="col-md-12 col-sm-12 col-12">
                <div class="toast" style="max-width: none;" id="myToast" data-delay="5000">
                    <div class="toast-header">
                        <strong class="mr-auto"><i class="fas fa-info-circle"></i>Mensaje de GBRoute</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">
                        @if(Session::has('Error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('Error') }}
                            </div>
                        @elseif(Session::has('Mensaje'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('Mensaje') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 m-t-10 text-center">
            <h5>Comprar en <strong class="rojo-red">GB Route</strong> es muy fácil</h5>
            <h6>inicia sesión para continuar con tu compra. ¿No estás registrado? Regístrate</strong></h6>                
        </div>
        <div class="col-12 col-md-6 col-xs-6 m-b-20 m-t-10">
            <div class="row">
            <div class="col-12 text-center titulo-valores">
                Nuestros Valores
            </div>
            <div class="col-6 col-md-6 col-xs-6 img-valores">
                <picture>
                    <source type="image/webp" srcset = "{{asset('storage/imagenesLayout/webp/side_img.webp') }}">
                    <source type="image/jpeg" srcset = "{{asset('storage/imagenesLayout/side_img.jpeg') }}"> 
                    <img src="{{asset('storage/imagenesLayout/side_img.jpeg') }}" class="text-center">
                </picture>
            </div>
            <div class="col-3 col-md-6 col-xs-6">
                <ul class="text-valores">
                <li>Compromiso</li>
                <li>Garantía</li>
                <li>Envío</li>
                <li>Calidad</li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-xs-4 m-b-20 m-t-10">
            <nav>
            <div class="nav nav-tabs" id="nav-reg" role="tablist">
                <a class="nav-item nav-link active" id="nav-inicias-tab" data-toggle="tab" href="#nav-inicias" role="tab" aria-controls="nav-inicias" aria-selected="true">Inicia Sesión</a>
                <a class="nav-item nav-link" id="nav-registro-tab" data-toggle="tab" href="#nav-registro" role="tab" aria-controls="nav-registro" aria-selected="false">Regístrate</a>                  
            </div>
            </nav>
            <div class="tab-content" id="nav-regcontenido">
            <div class="tab-pane fade show active" id="nav-inicias" role="tabpanel" aria-labelledby="nav-inicias-tab">
                <form role="form" action="{{ route('loginCliente')}}" method="post" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="col-12">
                        <div class="form-group m-b-20 m-t-10">
                        <label class="rojo-red" for="email">Correo electrónico:</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Ingresa tu nombre de usuario" autocomplete="off" required>
                        </div> 
                        <div class="form-group m-b-20 m-t-10">
                        <label class="rojo-red" for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="7 a 15 caracteres" autocomplete="off"  required>
                        </div>
                        <input type="hidden" name="redireccion" value="{{ Request::get('urlsig') }}">
                        <button type="submit" class="btn btn-danger bt-block m-b-20 m-t-10" style="width: 100%">
                        Entrar
                        </button>
                        <div class="m-b-20 m-t-10"><a href="#">¿Olvidaste tu contraseña?</a></div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="nav-registro" role="tabpanel" aria-labelledby="nav-registro-tab">
                <form role="form" action="{{ route('registroCliente')}}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="col-12">
                    <div class="form-group">
                    <label class="rojo-red" for="registro-nombre">Nombre(s):</label>
                    <input type="text" class="form-control" name="registro-nombre" id="registro-nombre" placeholder="Ingresa tu nombre(s)" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                    <label class="rojo-red" for="registro-correo">Correo electrónico:</label>
                    <h6 class="gris-gray">Te enviaremos a éste correo la confirmación de tus compras, entregas y envíos.</h6>
                    <input type="email" class="form-control" name="registro-correo" id="registro-correo" placeholder="Ingresa tu correo electrónico" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                    <label class="rojo-red" for="registro-pass">Contraseña:</label>
                    <input type="password" class="form-control" name="registro-pass" id="registro-pass" placeholder="7 a 15 caracteres" autocomplete="off"  required>
                    </div>
                    <div class="form-group">
                    <label class="rojo-red" for="registro-pass-confirmation">Confirmar contraseña:</label>
                    <input type="password" class="form-control" name="registro-pass_confirmation" id="registro-pass-confirmation" placeholder="7 a 15 caracteres" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                    <label class="rojo-red" for="registro-infoCorreo">Deseo recibir información por correo</label>
                    <input type="checkbox" class="" name="registro-infoCorreo" id="registro-infoCorreo" checked>
                    </div>
                    <input type="hidden" name="redireccion" value="{{ Request::get('urlsig') }}">
                    <button type="submit" class="btn btn-danger bt-block m-b-20" style="width: 100%">
                    Registrate y compra
                    </button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6LfQSLUUAAAAACQOzseZ3J9wWIEg1v5iU0Rtgnv9"></script>
    <script src="{{ asset('js/cliente/registro.js') }}"></script>
@endsection