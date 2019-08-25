<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/inicio.css')); ?>" type="text/css"> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-4 col-sm-12 col-12 collapse navbar-collapse show" id="navbarTogglerDemo01">
            <?php echo $__env->make('widgets.sidebarCategorias', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-md-8 col-sm-12 col-12">
            <hr>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('storage/imagenesLayout/banners/slide2_image.png')); ?>" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <span class="btn btn-danger">Comprar</span>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/imagenesLayout/banners/slide3_image.png')); ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/imagenesLayout/banners/slide4_image.png')); ?>" class="d-block w-100" alt="...">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div> 
            <hr>
            <div class="row">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-12 col-lg-6">
                        <div class="card mb-3">
                            <div class="row no-gutters">                 
                                <div class="col-md-6 col-6">
                                    <div class="card-body">
                                        <p class="card-title money">$<?php echo e($producto->precio); ?></p>
                                        <p class="card-text"><small><?php echo e($producto->nombre); ?></small></p>
                                        <div style="text-align: center"><a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>"class="btn btn-danger">Comprar</a></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <?php if(isset($producto->foto)): ?>
                                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>">
                                            <img class="card-img" alt="Imagen15" src="<?php echo e(asset('storage/imagenesProductos/'.$producto->foto->nombre)); ?>">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
            </div>
            <div class="row">
                <div class="col-md-3 col-xs-6">  
                    <img src="<?php echo e(asset('storage/imagenesProductos/borrame/saxofon-jupiter-jas700_iZ677905355XvZmediumXpZ1XfZ201650939-28989489872-6XsZ201650939xIM.jpg')); ?>" class="img-thumbnail" alt="imagen34">                
                    <span class="product-name">Saxofón Júpiter JAS700</span>
                    <div class="promos">
                        <div class="price">
                            <del class="old-price">
                                $ 29,220.00
                            </del>
                            <ins class="new-price">
                                $ 14,610.00
                            </ins>
                            <div class="pleca">
                                50 % OFF
                            </div>
                            <div class="ultimos">
                                ¡Últimos disponibles!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">  
                    <img src="<?php echo e(asset('storage/imagenesProductos/borrame/clarinete.jpg')); ?>" class="img-thumbnail" alt="imagen34">                
                    <span class="product-name">Clarinete Maxima Afinación Bb Mod. Ttc-50w/b</span>
                    <div class="promos">
                        <div class="price">
                            <del class="old-price">
                                $ 3,600.00
                            </del>
                            <ins class="new-price">
                                $ 1,800.00
                            </ins>
                            <div class="pleca">
                                50 % OFF
                            </div>
                            <div class="ultimos">
                                ¡Últimos disponibles!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">  
                    <img src="<?php echo e(asset('storage/imagenesProductos/borrame/saxofon-alto-jupiter-jas500-con-case_iZ1061888349XvZmediumXpZ1XfZ201650939-39549588214-7XsZ201650939xIM.jpg')); ?>" class="img-thumbnail" alt="imagen34">                
                    <span class="product-name">Saxofón Alto Júpiter Jas500 Con Case</span>
                    <div class="promos">
                        <div class="price">
                            <del class="old-price">
                                $ 27,100.00
                            </del>
                            <ins class="new-price">
                                $ 13,550.00
                            </ins>
                            <div class="pleca">
                                50 % OFF
                            </div>
                            <div class="ultimos">
                                ¡Últimos disponibles!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">  
                    <img src="<?php echo e(asset('storage/imagenesProductos/borrame/clarinete-klingt-de-madera-ft6402e_iZ1065997082XvZmediumXpZ1XfZ201650939-12985488861-3XsZ201650939xIM.jpg')); ?>" class="img-thumbnail" alt="imagen34">                
                    <span class="product-name">Clarinete Klingt De Madera FT-6402E</span>
                    <div class="promos">
                        <div class="price">
                            <del class="old-price">
                                $ 3,580.00
                            </del>
                            <ins class="new-price">
                                $ 1,790.00
                            </ins>
                            <div class="pleca">
                                50 % OFF
                            </div>
                            <div class="ultimos">
                                ¡Últimos disponibles!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/inicio.js')); ?>"></script>
  <input type="hidden" value="<?php echo e(route('catalogo')); ?>" id="rutaProductos">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>