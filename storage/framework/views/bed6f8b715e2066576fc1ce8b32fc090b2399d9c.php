<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/cliente/base.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<header class="header-tienda">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-xs-12">
                <a href="<?php echo e(route('inicio')); ?>">
                    <picture>
                        <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/logo.webp')); ?>">
                        <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>">
                        <img src="<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>" class="img-responsive" alt="Gb Shop">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>