<?php $__env->startSection('titulo'); ?>
Administración gbshop
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-12 col-sm-12 col-12">
        <br>
        <?php if(Session::has('Mensaje')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('Mensaje')); ?>

            </div>
        <?php elseif(Session::has('Error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(Session::get('Error')); ?>

            </div>
        <?php endif; ?>
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size:medium">
            <a class="nav-item nav-link active" id="nav-productos-tab" data-toggle="tab" href="#nav-productos" role="tab" aria-controls="nav-productos" aria-selected="true">Productos</a>
            <a class="nav-item nav-link" id="nav-marcas-tab" data-toggle="tab" href="#nav-marcas" role="tab" aria-controls="nav-marcas" aria-selected="false">Marcas</a>
            <a class="nav-item nav-link" id="nav-categorias-tab" data-toggle="tab" href="#nav-categorias" role="tab" aria-controls="nav-categorias" aria-selected="false">Categorias</a>
            <a class="nav-item nav-link" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="false">Admin</a>
            
            <a class="nav-item nav-link ml-auto" role = "tab" aria-controls="nav-admin" aria-selected="false" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active " id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
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
                                <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required>
                            </div>    
                            <div class="form-group">
                                <label for="producto-descripcion">Descripción</label>
                                <textarea class="form-control" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3"></textarea>
                            </div>  
                            <div class="form-group">
                                <label for="producto-marca">Marca</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-marca" id="producto-marca" required>
                                    <option value="">Seleccione una opción...</option>
                                    <option value="1">La Sevillana</option>
                                    <option value="2">Fender</option>
                                    <option value="3">VOX</option>
                                    <option value="4">SONOR</option>
                                    <option value="9">Signal Route</option>
                                </select>
                            </div>    
                            <div class="form-group">
                                <label for="producto-categoria">Categoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-categoria" id="producto-categoria" required>
                                    <option value="">Seleccione una opción...</option>
                                    <option value="1">Guitarras</option>
                                    <option value="2">Eléctricas</option>
                                    <option value="3">Acusticas</option>
                                    <option value="4">Electroacústicas</option>
                                    <option value="5">Paquetes de guitarra</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="producto-subcategoria">SubCategoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria">
                                    <option value="">Seleccione una opción...</option>
                                    <option value="1">Guitarras</option>
                                    <option value="2">Eléctricas</option>
                                    <option value="3">Acusticas</option>
                                    <option value="4">Electroacústicas</option>
                                    <option value="5">Paquetes de guitarra</option>
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
                                <input type="file" class="form-control" name="producto-foto" id="producto-foto" required>
                            </div> 
                            <button type="submit" class="btn btn-primary">Agregar a la Página</button>                                                      
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
        <div class="tab-pane fade" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
            Marcas
        </div>
        <div class="tab-pane fade" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
            Categorias
        </div>
        <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
            Panel de Administración
        </div>

        </div>
        
        </div>    
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>