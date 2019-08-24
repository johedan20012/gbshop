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
                    <strong class="mr-auto"><i class="fa fa-grav"></i>Mensaje de GBShop</strong>
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
            <?php if( $numPag == 1 || $numPag == 5 ): ?>
                <a class="nav-item nav-link active" id="nav-productos-tab" data-toggle="tab" href="#nav-productos" role="tab" aria-controls="nav-productos" aria-selected="true">Productos</a>
            <?php else: ?>
                <a class="nav-item nav-link" id="nav-productos-tab" data-toggle="tab" href="#nav-productos" role="tab" aria-controls="nav-productos" aria-selected="false">Productos</a>
            <?php endif; ?>
            <?php if($numPag == 2): ?>
                <a class="nav-item nav-link active" id="nav-marcas-tab" data-toggle="tab" href="#nav-marcas" role="tab" aria-controls="nav-marcas" aria-selected="true">Marcas</a>
            <?php else: ?>
                <a class="nav-item nav-link" id="nav-marcas-tab" data-toggle="tab" href="#nav-marcas" role="tab" aria-controls="nav-marcas" aria-selected="false">Marcas</a>
            <?php endif; ?>
            <?php if($numPag == 3): ?>
                <a class="nav-item nav-link active" id="nav-categorias-tab" data-toggle="tab" href="#nav-categorias" role="tab" aria-controls="nav-categorias" aria-selected="true">Categorias</a>
            <?php else: ?>
                <a class="nav-item nav-link" id="nav-categorias-tab" data-toggle="tab" href="#nav-categorias" role="tab" aria-controls="nav-categorias" aria-selected="false">Categorias</a>
            <?php endif; ?>
            <?php if($numPag == 4): ?>
                <a class="nav-item nav-link active" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="true">Admin</a>
            <?php else: ?>
                <a class="nav-item nav-link" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="false">Admin</a>
            <?php endif; ?>
            
            <a class="nav-item nav-link ml-auto" role = "tab" aria-controls="nav-admin" aria-selected="false" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
        <?php if( $numPag == 1 || $numPag == 5 ): ?>
        <div class="tab-pane fade show active" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
        <?php else: ?>
        <div class="tab-pane fade" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
        <?php endif; ?>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <br>
                    <div id="add-producto">
                        <h4 aling="center" class="titulo">
                            <i class="fa fa-plus"></i>
                            Agregar Productos
                        </h4>
                        <form role="form" action="<?php echo e(route('regProducto')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                <label for="producto-nombre">Nombre</label>
                                <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required value="<?php echo e(old('producto-nombre')); ?>">
                            </div>    
                            <div class="form-group">
                                <label for="producto-descripcion">Descripción</label>
                                <textarea class="form-control" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3"><?php echo e(old('producto-descripcion')); ?></textarea>
                            </div>  
                            <div class="form-group">
                                <label for="producto-marca">Marca</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-marca" id="producto-marca" required>
                                    <option value="">Seleccione una opción...</option>
                                    <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($marca->idmarcas); ?>"><?php echo e($marca->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>    
                            <div class="form-group">
                                <label for="producto-categoria">Categoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-categoria" id="producto-categoria" required>
                                    <option value="">Seleccione una opción...</option>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->idcategorias); ?>"><?php echo e($categoria->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="producto-subcategoria">SubCategoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria">
                                    <option value="">Seleccione una opción...</option>
                                </select>
                            </div> 
                            <label for="producto-precio">Precio</label>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="number" class="form-control" name="producto-precio" id="producto-precio" placeholder="Precio" required step=".01">
                            </div>  
                            <div class="form-group">
                                <label for="producto-foto">Selecciona Imágen...</label>
                                <input type="file" class="form-control" multiple name="producto-foto[]" id="producto-foto" required>
                            </div> 
                            <button type="submit" class="btn btn-danger">Agregar a la Página</button>                                                      
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <br>
                    <div id="del-producto-form">
                        Poner para Borrar segunda columna
                    </div>
                </div>
            </div>
        </div>
        <?php if( $numPag == 2): ?>
        <div class="tab-pane fade show active" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
        <?php else: ?>
        <div class="tab-pane fade" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
        <?php endif; ?>
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
        <?php if( $numPag == 3): ?>
        <div class="tab-pane fade show active" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
        <?php else: ?>
        <div class="tab-pane fade" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
        <?php endif; ?>
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
                        <?php echo $__env->make('widgets.tablaCategorias', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
            </div>  
        </div>
        <?php if( $numPag == 4): ?>
        <div class="tab-pane fade show active" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
        <?php else: ?>
        <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
        <?php endif; ?>
            Panel de Administración
        </div>

        </div>
        
        </div>    
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <input type="hidden" value="<?php echo e(route('subCat')); ?>" id="rutaSubCategorias">
    <input type="hidden" value="<?php echo e(route('admin')); ?>" id="rutaMarcas">
    <script src="<?php echo e(asset('js/auth/admin.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>