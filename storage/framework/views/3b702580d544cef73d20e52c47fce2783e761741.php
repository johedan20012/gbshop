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
                        <?php $banner = pathinfo($banner, PATHINFO_FILENAME); ?>
                        <?php if($cont == 0): ?>
                            <div class="carousel-item active" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                        <?php else: ?>
                            <div class="carousel-item" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                        <?php endif; ?>
                                <picture>
                                    <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/banners/'.$banner.'.webp')); ?>">
                                    <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/banners/'.$banner.'.png')); ?>">
                                    <img src="<?php echo e(asset('storage/imagenesLayout/banners/'.$banner.'.png')); ?>" class="d-block w-100" alt="...">
                                </picture>
                            </div>
                        <?php $cont = 1;?>
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
                                        <picture>
                                            <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/agotado.webp')); ?>">
                                            <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>">
                                            <img src="<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>" style="position: absolute; z-index : 2; width: 45%; top: 15%;" >
                                        </picture>
                                    <?php endif; ?>
                                    <?php if(isset($producto->foto)): ?>
                                        <?php $fotoProducto = pathinfo($producto->foto->nombre, PATHINFO_FILENAME); ?>
                                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" >
                                            <div class = "dimensiones2" style="padding:15px;">
                                                <div class = "contImgProducto">
                                                    <picture>
                                                        <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp')); ?>">
                                                        <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>">
                                                        <img src="<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>" class="d-block w-100" alt="...">
                                                    </picture>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/inicio.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>