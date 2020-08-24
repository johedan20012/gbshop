<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- font Awesome CDN-->
    <script src="https://kit.fontawesome.com/66cdcaa667.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>"> <!--Bootstrap 4-->
    <link rel="stylesheet" href="<?php echo e(asset('css/base.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>

    <title><?php echo $__env->yieldContent('titulo'); ?></title>
  </head>
  <body  class="d-flex flex-column" style="min-height:100vh;">

    <?php $__env->startSection('header'); ?>
    <header>
      <div class="container" id="encabezado">
        <div class="row">
          <div class="col-md-12">
              <a href="<?php echo e(route('inicio')); ?>">
                <picture>
                  <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/logo.webp')); ?>">
                  <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>">
                  <img src="<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>" class="img-responsive" alt="Gb Shop">
                </picture>
              </a>
              <?php if(Auth::check()): ?>
                <a class="text-white" href="<?php echo e(route('admin')); ?>">Panel de administración</a>
              <?php endif; ?>
          </div>
        </div>
        <?php if(!isset($sinNavbar)): ?>
          <nav class="navbar navbar-expand-lg navbar-light bg-danger">
            <div class="container">
              <div class="row col-md-12">
                <div class="col-12 col-md-5">
                  <form class="my-2 my-lg-0" action="<?php echo e(route('catalogo')); ?>" method="GET">
                    <input class="form-control" type="search" placeholder="Buscar..." aria-label="Buscar" name="cadena">                  
                  </form>
                </div>
                <div class="col-2 col-md-2">
                  <?php if(isset($conSideBar)): ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>              
                  <?php endif; ?>
                </div> 
                <div class="col-10 col-md-5">
                  <div class="dropdown" id="cart">
                    <div class="btn-group">
                      <a href="#" class="dropdown-toggle" type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff">
                        <i class="fas fa-shopping-cart bco"></i>
                        <span class="text-option" style="color: #fff">Mi Carrito</span>
                        <div class="circulo">
                          <h2>
                            <?php if( Session::get('productos') !== null ): ?> 
                              <?php echo e(Session::get('productos')); ?> 
                            <?php else: ?> 
                              0 
                            <?php endif; ?>
                          </h2>
                        </div>
                      </a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo e(route('carritoUsuario')); ?>">
                          <i class="fas fa-dollar-sign"></i>   
                          Total: 
                          <?php if( Session::get('total') !== null ): ?> 
                            <?php echo e(number_format (Session::get('total'),2)); ?> 
                           <?php else: ?> 
                            0.00 
                          <?php endif; ?>
                        </a>
                        <?php if( Session::get('productos') !== null ): ?> 
                          <a class="dropdown-item" href="<?php echo e(route('confirmCompra')); ?>"><i class="fas fa-check-circle"></i>   Confirmar compra</a>
                        <?php endif; ?>
                      </div>
                    </div>

                    <?php if(!(Auth::guard('cliente')->check() || Auth::check())): ?>
                    <a href="#" data-toggle="modal" style="color: #fff" data-target="#ModalLogin"><i class="fas fa-sign-in-alt"></i>   Iniciar Sesión</a>
                    <?php endif; ?>
                    
                    <?php if(Auth::guard('cliente')->check()): ?>
                      <div class="btn-group">
                        <a href="#" class="dropdown-toggle" type="" id="dropdownMenuUsuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-user bco"></i>
                          <span class="text-option" style="color: #fff"><?php echo e(Auth::guard('cliente')->user()->nombreCompleto); ?></span>
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?php echo e(route('panelUsuario')); ?>"><i class="fas fa-address-card"></i>   Mi cuenta</a>
                          <a class="dropdown-item" href="<?php echo e(route('panelUsuario')); ?>?panel=3"><i class="fas fa-file-alt"></i>   Mis Pedidos</a>
                          <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><i class="fas fa-sign-in-alt"></i>   Cerrar Sesión</a>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>  
            </div>
          </nav>
        <?php endif; ?>
      </div>  
    </header>
    <?php echo $__env->yieldSection(); ?>
    
    <div id="main" class="container-fluid py-3 flex-fill">
        <?php echo $__env->yieldContent('contenido'); ?>
    </div>

    <footer class="container-fluid w-100 py-3">
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
                <li class="contacts_phone lastItem"><span>Tel: 777 629 0048</span></li>
              </ul>
          </div>
        </div>
      </div>
      <div class="copyright" role="contentinfo">
        <div class="container">    
          <div class="fiscal-data-container">
            <dl class="fiscalData">
              <dd>Musical Cortés S. de R.L. &nbsp;</dd>
              <dd class="text-center tittles-pages-logo"> <a style="color:white;" href="<?php echo e(route('politicas')); ?>" title="Política de Privacidad">Política de Privacidad</a> </dd>
            </dl>
          </div>
          &copy; 2020 Musical Cortés S. de R.L.
        </div>
      </div>
    </footer>
    
    <script src="<?php echo e(asset('js/app.js')); ?>"></script> <!--JQUERY-->
    <?php echo $__env->yieldContent('scripts'); ?>

    <?php if(!isset($sinNavbar) && !(Auth::guard('cliente')->check() || Auth::check())): ?>
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
              <form role="form" action="<?php echo e(route('loginCliente')); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                  <label for="UserName"><i class="fas fa-user"></i> Correo electrónico</label>
                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailhelp" placeholder="Nombre de Usuario" autocomplete="off" value="<?php echo e(old('username')); ?>" required>
                </div>
                <div class="form-group">
                  <label for="Password"><i class="fas fa-lock"></i> Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" aria-describedby="userpasshelp" placeholder="Contraseña" required>
                </div>
                <label>
                  <input type="checkbox" name="remember" value="<?php echo e(old('remember') ? 'checked' : ''); ?>"> Recuerdame
                </label>
                <a class="mr-0" href="<?php echo e(route('registro')); ?>">Registrarse</a>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary btn-sm">Iniciar Sesión</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endif; ?>
  </body>
</html>