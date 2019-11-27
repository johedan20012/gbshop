<?php $__env->startSection('contenido'); ?>
<?php
    if(!isset($numPanel)){
        $numPanel = 1;
    }elseif($numPanel != 1 && $numPanel != 2 && $numPanel != 3){
        $numPanel = 1;
    }
?>
<div class="container">
    <div class="row"> 
        <div class="col-md-12 justify-content-center">
            <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <?php if(Session::has('Mensaje') || Session::has('Error')): ?>
            <div class="col-12 col-md-12">
                <div class="toast" id="myToast" data-delay="3000" style="max-width: none;">
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-2 m-t-10 text-center" style="border: 2px gray solid; border-radius:8px;"> 
            <div class="p-3 row">
                <?php if($numPanel != 2): ?>
                    <a href="<?php echo e(route('panelUsuario').'?panel=2'); ?>">Editar información</a>
                <?php else: ?>
                    Editar información
                <?php endif; ?>
            </div>
            <hr style="margin: 0;">
            <div class="p-3 row">
                <?php if($numPanel != 3): ?>
                    <a href="<?php echo e(route('panelUsuario').'?panel=3'); ?>">Historial de pedidos</a>
                <?php else: ?>
                    Historial de pedidos
                <?php endif; ?>
            </div>
        </div>           
        <div class="col-md-10 m-t-10 ">
            <?php echo $__env->yieldContent('panel'); ?>                   
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(document).ready(function(){
            //Toast de mensaje de alert, succes o warning
            if($("#myToast") != null) $("#myToast").toast('show');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.cliente.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>