<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-pedidos" role="tabpanel" aria-labelledby="nav-pedidos-tab ">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <br>
            <div id="del-pedido">
                <div id="del-pedido-form">
                    <?php echo $__env->make("widgets.admin.tablaPedidos", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <input type="hidden" value="<?php echo e(route('tablaPedidos')); ?>" id="rutaPedidos">
    <input type="hidden" value="<?php echo e(route('editEstatusPedido')); ?>" id="rutaEditarEstatus">
    <input type="hidden" value="<?php echo e(route('reenviarCorreo')); ?>" id="rutaReenviarCorreo">
    <script src="<?php echo e(asset('js/admin/tabPedidos.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>