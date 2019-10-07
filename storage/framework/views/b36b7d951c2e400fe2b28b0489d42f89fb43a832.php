<?php $__env->startSection('panel'); ?>
    <h3>Bienvenido, <strong class="rojo-red" style="text-transform: uppercase;"><?php echo e(Auth::user()->nombreCompleto); ?></strong></h3>
    <hr>       
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cliente.basePanel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>