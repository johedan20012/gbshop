<?php $__env->startSection('contenido'); ?>
<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-center">
            <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-md-12 m-t-10 ">
            <?php if($pedido != null): ?>
                <?php echo $__env->make('correos.correoCompra', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
                No se pudo encotrar el pedido con la clave proporcionada.
            <?php endif; ?>            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cliente.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>