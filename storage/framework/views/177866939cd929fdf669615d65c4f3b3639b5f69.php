<?php $__env->startSection('titulo'); ?>
Error
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($message); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('catalogo')); ?>">Volver al Inicio</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>