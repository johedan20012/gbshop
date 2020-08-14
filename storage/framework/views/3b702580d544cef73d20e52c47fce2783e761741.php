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
                    <?php $cont = 0; ?>
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($cont == 0): ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($cont); ?>" class="active"></li>
                        <?php else: ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($cont); ?>"></li>
                        <?php endif; ?>
                        <?php $cont +=1?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
                <div class="carousel-inner">
                    <?php $cont = 0; ?>
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($cont == 0): ?>
                            <div class="carousel-item active" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                                <img src="<?php echo e(asset('storage/imagenesLayout/banners/'.$banner)); ?>" class="d-block w-100" alt="...">
                            </div>
                        <?php else: ?>
                            <div class="carousel-item" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                                <img src="<?php echo e(asset('storage/imagenesLayout/banners/'.$banner)); ?>" class="d-block w-100" alt="...">
                            </div>
                        <?php endif; ?>
                        <?php $cont +=1?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
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
                                        <?php if($producto->stock > 0): ?>
                                            <div style="text-align: center"><a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>"class="btn btn-danger">Comprar</a></div>
                                        <?php else: ?>
                                            <div style="text-align: center"><a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>"class="btn btn-danger">Ver</a></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <?php if($producto->stock <= 0): ?>
                                        <img src="<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>" style="position: absolute; z-index : 2; width: 45%; top: 15%;" >
                                    <?php endif; ?>
                                    <?php if(isset($producto->foto)): ?>
                                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" >
                                            <div style="padding:15px; height:100%; width:100%;">
                                                <div class="dimensiones2" style="background: url(<?php echo e(asset('storage/imagenesProductos/'.$producto->foto->nombre)); ?>) no-repeat  center; background-size: contain;"> </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
            </div>
            <div class="row">
                <!--
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
                </div> -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/inicio.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>