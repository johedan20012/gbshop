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
  <body>
    <header>
      <div class="container" id="encabezado">
        <div class="row">
          <div class="col-md-12">
              <a href="<?php echo e(route('inicio')); ?>">
              <img src="<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>" class="img-responsive" alt="Gb Shop">
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
                    <a href="#" class="dropdown-toggle" type="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-shopping-cart bco"></i>
                      <span class="text-option" style="color: #fff">Mi Carrito</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i>   Total: $6,500.00</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i>   Mis Pedidos</a>
                      <a class="dropdown-item" href="#"><i class="fas fa-edit"></i>   Registrarse</a>
                    </div>
                  </div>
                </div>
              </div>  
            </div>
          </nav>
        <?php endif; ?>
      </div>  
    </header>

    <div id="main">
        <?php echo $__env->yieldContent('contenido'); ?>;
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
    
    <script src="<?php echo e(asset('js/app.js')); ?>"></script> <!--JQUERY-->
    <?php echo $__env->yieldContent('scripts'); ?>
  </body>
</html>