<?php $__env->startSection('titulo'); ?>
Administración gbshop
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/auth/admin.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<?php
    if(!isset($numPag)){
        $numPag = 5;
    }elseif($numPag != 1 && $numPag != 2 && $numPag != 3 && $numPag != 4){
        $numPag = 5;
    }
    
?>

<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-12 col-sm-12 col-12">
        <br>
        <?php if(Session::has('Mensaje') || Session::has('Error') || Session::has('Warning')): ?>
            <div class="toast" id="myToast" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fas fa-info-circle"></i>Mensaje de GBRoute</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    <?php if(Session::has('Mensaje')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(Session::get('Mensaje')); ?>

                        </div>
                    <?php elseif(Session::has('Error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(Session::get('Error')); ?>

                        </div>
                    <?php elseif(Session::has('Warning')): ?>
                    <div class="alert alert-warning" role="alert">
                            <?php echo e(Session::get('Warning')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size:medium">
            <?php if( $numPag == 1 || $numPag == 6 ): ?>
                <a href = "<?php echo e(route('admin').'?panel=1'); ?>" class="nav-item nav-link active" id="nav-productos-tab" aria-selected="true">Productos</a>
            <?php else: ?>
                <a href = "<?php echo e(route('admin').'?panel=1'); ?>" class="nav-item nav-link" id="nav-productos-tab" aria-selected="false">Productos</a>
            <?php endif; ?>
            <?php if($numPag == 2): ?>
                <a href = "<?php echo e(route('admin').'?panel=2'); ?>" class="nav-item nav-link active" id="nav-marcas-tab" aria-selected="true">Marcas</a>
            <?php else: ?>
                <a href = "<?php echo e(route('admin').'?panel=2'); ?>" class="nav-item nav-link" id="nav-marcas-tab" aria-selected="false">Marcas</a>
            <?php endif; ?>
            <?php if($numPag == 3): ?>
                <a href = "<?php echo e(route('admin').'?panel=3'); ?>" class="nav-item nav-link active" id="nav-categorias-tab" aria-selected="true">Categorias</a>
            <?php else: ?>
                <a href = "<?php echo e(route('admin').'?panel=3'); ?>" class="nav-item nav-link" id="nav-categorias-tab" aria-selected="false">Categorias</a>
            <?php endif; ?>
            <?php if($numPag == 4): ?>
                <a href = "<?php echo e(route('admin').'?panel=4'); ?>" class="nav-item nav-link active" id="nav-admins-tab" aria-selected="true">Admin</a>
            <?php else: ?>
                <a href = "<?php echo e(route('admin').'?panel=4'); ?>" class="nav-item nav-link" id="nav-admins-tab" aria-selected="false">Admin</a>
            <?php endif; ?>
            <?php if($numPag == 5): ?>
                <a href = "<?php echo e(route('admin').'?panel=5'); ?>" class="nav-item nav-link active" id="nav-admin-tab" aria-selected="true">Pedidos</a>
            <?php else: ?>
                <a href = "<?php echo e(route('admin').'?panel=5'); ?>" class="nav-item nav-link" id="nav-admin-tab" aria-selected="false">Pedidos</a>
            <?php endif; ?>
            <a class="nav-item nav-link ml-auto" role = "tab" aria-controls="nav-admin" aria-selected="false" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <?php echo $__env->yieldContent('nav-tab'); ?>
        </div>
        
        </div>    
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/admin/admin.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>