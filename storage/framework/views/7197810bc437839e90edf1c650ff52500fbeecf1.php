<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <br>
            <div id="add-producto">
                <h4 aling="center" class="titulo">
                    <i class="fa fa-plus"></i>
                    Agregar Productos
                </h4>
                <form role="form" action="<?php echo e(route('regProducto')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    
                    <div class="row">
                        <div class="col-12 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="producto-nombre">Nombre</label>
                                <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required value="<?php echo e(old('producto-nombre')); ?>">
                            </div>    
                            <div class="form-group">
                                <label for="producto-descripcion">Descripción</label>
                                <textarea class="form-control" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3"><?php echo e(old('producto-descripcion')); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="producto-modelo">Modelo</label>
                                <input type="text" class="form-control" name="producto-modelo" id="producto-modelo" placeholder="Modelo" rows="3"><?php echo e(old('producto-modelo')); ?></input>
                            </div>  
                            <div class="form-group">
                                <label for="producto-atributos">Atributos</label>
                                <textarea class="form-control" name="producto-atributos" id="producto-atributos" placeholder="Atributos" rows="3"><?php echo e(old('producto-atributos')); ?></textarea>
                            </div>   
                        </div>
                        <div class="col-12 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="producto-marca">Marca</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-marca" id="producto-marca" required>
                                    <option value="">Seleccione una marca...</option>
                                    <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($marca->idmarcas); ?>"><?php echo e($marca->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="producto-categoria">Categoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-categoria" id="producto-categoria" required>
                                    <option value="">Seleccione una categoria...</option>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->idcategorias); ?>"><?php echo e($categoria->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="producto-subcategoria">SubCategoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria">
                                    <option value="">Sin subcategoria</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-sm-6">
                                    <label for="producto-precio">Precio</label>
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number" class="form-control" name="producto-precio" id="producto-precio" placeholder="Precio" required min="0" step=".01">
                                    </div>  
                                </div>
                                <div class="col-12 col-md-6 col-sm-6">
                                    <label for="producto-stock">Stock</label>
                                    <div class="input-group form-group">
                                        <input type="number" class="form-control" min="0" value="0" name="producto-stock" id="producto-stock" placeholder="Stock" required step="1">
                                    </div>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="producto-foto">Selecciona Imágen...(Maximo 10 fotos, 2MB maximo por cada una)</label>
                                <input type="file" class="form-control" multiple name="producto-foto[]" id="producto-foto" required>
                            </div> 
                            <button type="submit" class="btn btn-danger">Agregar a la Página</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div> 
        <div class="col-md-12 col-12">
            <br>
            <div id="del-producto">
                <div id="del-producto-form">
                    <?php echo $__env->make('widgets.admin.tablaProductos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <br>
            <a href="<?php echo e(route('reportProductos')); ?>"><button type="button"  class="btn btn-danger">Descargar reporte de productos</button></a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
        <input type="hidden" value="<?php echo e(route('subCat')); ?>" id="rutaSubCategorias">
        <input type="hidden" value="<?php echo e(route('tablaProductos')); ?>" id="rutaProductos">
        <input type="hidden" value="<?php echo e(route('fotosProducto')); ?>" id="rutaFotosProducto">
        <input type="hidden" value="<?php echo e(route('delProducto')); ?>" id="rutaDelProducto">
        <input type="hidden" value="<?php echo e(route('editProducto')); ?>" id="rutaEditProducto">
        <script src="<?php echo e(asset('js/admin/tabProductos.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>