<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
    Panel de administradores
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>