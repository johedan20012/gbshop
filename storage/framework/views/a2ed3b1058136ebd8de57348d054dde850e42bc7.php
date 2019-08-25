<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="add-marca">
            <h4 aling="center" class="titulo">
            <i class="fa fa-plus"></i>
            Agregar Marca
            </h4>
            <form role="form" action="<?php echo e(route('storeMarca')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
                <label for="marca-nombre">Nombre</label>
                <input type="text" class="form-control" name="marca-nombre" id="marca-nombre" placeholder="Nombre" required>
            </div>
            <button type="submit" class="btn btn-danger">Agregar a la Página</button>                                                      
            </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="del-marca">
            <div id="del-marca-form">
                <?php echo $__env->make('widgets.tablaMarcas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
        <input type="hidden" value="<?php echo e(route('admin')); ?>" id="rutaMarcas">
        <script src="<?php echo e(asset('js/admin/tabMarcas.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>