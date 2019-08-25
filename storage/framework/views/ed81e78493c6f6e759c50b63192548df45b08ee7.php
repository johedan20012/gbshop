<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="add-categoria">
            <h4 aling="center" class="titulo">
            <i class="fa fa-plus"></i>
            Agregar Categoria / SubCategoria
            </h4>
            <form role="form" action="<?php echo e(route('storeCategoria')); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <label for="categoria-nombre">Nombre:</label>
                    <input type="text" class="form-control" name="categoria-nombre" id="categoria-nombre" required>
                </div>
                <div class="form-group">
                    <label for="categoria-padre">Pertenece a la categoria:</label>
                    <select class="form-control" name="categoria-padre" id="categoria-padre">
                    <option value="">Seleccione una opción</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->idcategorias); ?>"><?php echo e($categoria->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-danger" value="Agregar a la Página">                                                      
            </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="del-categoria">
            <div id="del-categoria-form">
                <?php echo $__env->make('widgets.admin.tablaCategorias', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
        <input type="hidden" value="<?php echo e(route('tablaCategorias')); ?>" id="rutaCategorias">
        <input type="hidden" value="<?php echo e(route('editCategoria')); ?>" id="rutaEditCategoria">
        <input type="hidden" value="<?php echo e(route('delCategoria')); ?>" id="rutaDelCategoria">
        <script src="<?php echo e(asset('js/admin/tabCategorias.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>