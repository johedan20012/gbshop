<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font Awesome CDN-->
    <script src="https://kit.fontawesome.com/66cdcaa667.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}"> <!--Bootstrap 4-->
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    @yield('css')

    <title>@yield('titulo')</title>
  </head>
  <body>

    @section('header')
    <header>
      <div class="container" id="encabezado">
        <div class="row">
          <div class="col-md-12">
              <a href="{{ route('inicio')}}">
              <img src="{{asset('storage/imagenesLayout/logo.png') }}" class="img-responsive" alt="Gb Shop">
              </a>
              @if(Auth::check())
                <a class="text-white" href="{{ route('admin')}}">Panel de administración</a>
              @endif
          </div>
        </div>
        @if(!isset($sinNavbar))
          <nav class="navbar navbar-expand-lg navbar-light bg-danger">
            <div class="container">
              <div class="row col-md-12">
                <div class="col-12 col-md-5">
                  <form class="my-2 my-lg-0" action="{{route('catalogo')}}" method="GET">
                    <input class="form-control" type="search" placeholder="Buscar..." aria-label="Buscar" name="cadena">                  
                  </form>
                </div>
                <div class="col-2 col-md-2">
                  @if(isset($conSideBar))
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>              
                  @endif
                </div> 
                <div class="col-10 col-md-5">
                  <div class="dropdown" id="cart">
                    <a href="#" class="dropdown-toggle" type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-shopping-cart bco"></i>
                      <span class="text-option" style="color: #fff">Mi Carrito</span>
                    </a>
                    @if(Auth::guard('cliente')->check())
                      <span class="text-option" style="color: #fff">{{ Auth::guard('cliente')->user()->username}}</span>
                    @endif
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i>   Total: $6,500.00</a>
                      @if(Auth::guard('cliente')->check())
                        <a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i>   Mis Pedidos</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-in-alt"></i>   Cerrar Sesión</a>
                      @endif
                      @if(!(Auth::guard('cliente')->check() || Auth::check())) <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalLogin"><i class="fas fa-sign-in-alt"></i>   Iniciar Sesión</a>@endif
                      <!-- <a class="dropdown-item" href="#"><i class="fas fa-edit"></i>   Registrarse</a>-->
                    </div>
                  </div>
                </div>
              </div>  
            </div>
          </nav>
        @endif
      </div>  
    </header>
    @show
    
    <div id="main">
        @yield('contenido');
    </div>

    <footer >
      <div class="container" id="pie">
        <div class="row">
          <div class="col-sm-3 custom_footer custom_footer3">
            <h4>Síguenos</h4>
            <ul class="social_footer_icons">
              <li class="firstItem">
                <a href="https://www.facebook.com/gbroutemusic" target="_blank">
                  <i class="fab fa-facebook"></i><span>Facebook</span>
                </a>
              </li>
              <li class="lastItem">
                <a href="https://www.youtube.com/channel/UCWoN-0J8tAsE8Pf1comQsQA/featured" target="_blank">
                  <i class="fab fa-youtube"></i><span>Youtube</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-sm-6 custom_footer custom_footer4">
              <h4>Contáctanos</h4>
              <ul>
                <li class="contacts_company firstItem">GB Route Music Store</li>
                <li class="contacts_address">Mariano Matamoros 39, Col. Centro, C.p. 62000, Cuernavaca, Morelos</li>
                <li class="contacts_phone lastItem">Tel: 777 311 2741</li>
              </ul>
          </div>
        </div>
      </div>
      <div class="copyright" role="contentinfo">
        <div class="container">    
          <div class="fiscal-data-container">
            <dl class="fiscalData">
              <dd>Musical Cortés S. de R.L.</dd>
              <dd class="document-type"> RFC: MCO180312BT7</dd>
            </dl>
          </div>
          &copy; 2019 Musical Cortés S. de R.L.
        </div>
      </div>
    </footer>
    
    <script src="{{ asset('js/app.js') }}"></script> <!--JQUERY-->
    @yield('scripts')

    @if(!isset($sinNavbar) && !(Auth::guard('cliente')->check() || Auth::check()))
      <!-- Modal login clientes -->
      <div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title text-danger text-bold" id="ModalLabel">Iniciar Sesión en GB Route</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" action="{{ route('loginCliente') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="UserName"><i class="fas fa-user"></i> Usuario</label>
                  <input type="text" class="form-control" id="username" name="username" aria-describedby="usernamehelp" placeholder="Nombre de Usuario" autocomplete="off" value="{{old('username')}}" required>
                </div>
                <div class="form-group">
                  <label for="Password"><i class="fas fa-lock"></i> Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" aria-describedby="userpasshelp" placeholder="Contraseña" required>
                </div>
                <label>
                  <input type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}"> Recuerdame
                </label>
                <a class="" href="#">Registrarse</a>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary btn-sm">Iniciar Sesión</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @endif
  </body>
</html>