<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

    <!-- font Awesome CDN-->
    <script src="https://use.fontawesome.com/025d1f53df.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>"> <!--Bootstrap 4-->
    <link rel="stylesheet" href="<?php echo e(asset('css/base.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>

    <!--<title>GB Route Music Store: Tienda online</title> -->
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
            <i class="fa fa-facebook"></i><span>Facebook</span>
          </a>
        </li>
      
          <li class="lastItem">
          <a href="https://www.youtube.com/channel/UCWoN-0J8tAsE8Pf1comQsQA/featured" target="_blank">
            <i class="fa fa-youtube"></i><span>Youtube</span>
          </a>
        </li>
      
      
      
      
                  </ul>
              </div>
            
                      <div class="col-sm-3 custom_footer custom_footer4">
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
  </body>
</html>