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
                    <img src="<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>"  alt="Gb Shop">
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


<?php $__env->startSection('contenido'); ?>


<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-cente">
            <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-md-3 m-t-10 text-center">
            <div class="m-t-10"><a href="<?php echo e(route('panelUsuario').'?panel=2'); ?>">Editar información</a></div><br>
            <div class="m-t-10 m-b-20">Historial de compras</div>
        </div>           
        <div class="col-md-9 m-t-10 ">
            <?php echo $__env->yieldContent('panel'); ?>                   
        </div>
        <div class="col-md-12">
            
                
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>