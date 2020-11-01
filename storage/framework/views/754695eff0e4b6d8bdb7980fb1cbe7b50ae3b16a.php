<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $productos->links('widgets.pagination'); ?>

    </div>

    <form class="form-inline mr-3" id="buscarProducto" action="">          
        <?php if(isset($actual)): ?>  
            <input type="search" class="form-group" name="producto-busca" id="producto-busca" placeholder="Buscar" value="<?php echo e($actual); ?>"> 
        <?php else: ?>
            <input type="search" class="form-group" name="producto-busca" id="producto-busca" placeholder="Buscar"> 
        <?php endif; ?>            
                               
        <i class="fa fa-search"></i>
    </form>

    <?php if(isset($actual)): ?>  
        <input type="hidden" id="producto-actual" value="<?php echo e($actual); ?>">  
    <?php else: ?>
        <input type="hidden" id="producto-actual" value=""> 
    <?php endif; ?>
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre</th>
    <th scope="col">Descripcion</th>
    <th scope="col">Marca</th>
    <th scope="col">Categoria</th>
    <th scope="col">Precio</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    <?php if(count($productos) == 0): ?>
        No se encontraron productos con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td class="nombre-producto" id="<?php echo e($producto->idproductos); ?>nombre"><?php echo e($producto->nombre); ?></td>
        <td class="descripcion-producto" ><textarea rows="4" cols="50" disabled id="<?php echo e($producto->idproductos); ?>desc"><?php echo e($producto->descripcion); ?></textarea></td>
        <td class="marca-producto" ><?php echo e($producto->marca->nombre); ?></td>
        <td class="categoria-producto" ><?php echo e($producto->categoria->nombre); ?></td>
        <td class="precio-producto" >$<?php echo e($producto->precio); ?></td>
        <input type="hidden" id="<?php echo e($producto->idproductos); ?>precio" value="<?php echo e($producto->precioSF); ?>">
        <input type="hidden" id="<?php echo e($producto->idproductos); ?>stock" value="<?php echo e($producto->stock); ?>">
        <input type="hidden" id="<?php echo e($producto->idproductos); ?>modelo" value="<?php echo e($producto->modelo); ?>">
        <input type="hidden" id="<?php echo e($producto->idproductos); ?>atributos" value="<?php echo e($producto->atributosStr); ?>">
        <?php if($producto->categoria->padre != null): ?>
          <input type="hidden" id="<?php echo e($producto->idproductos); ?>categoriaPadre" value="<?php echo e($producto->categoria->padre->idcategorias); ?>">
        <?php endif; ?>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-type="1" data-marca="<?php echo e($producto->marca->idmarcas); ?>" data-categoria="<?php echo e($producto->categoria->idcategorias); ?>" data-id="<?php echo e($producto->idproductos); ?>"  data-target="#modalProductos" ><i class="fa fa-edit" style="color:blue"> </i> Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-type="2" data-id="<?php echo e($producto->idproductos); ?>"  data-target="#modalProductos" ><i class="fa fa-times" style="color: red"> </i> Eliminar</button>
            </div>
            </div>
        </td>
        </tr>
        <tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    </tr>
</tbody>
</table>

<!--Modales-->

<div class="modal fade" id="modalProductos" tabindex="-1" role="dialog" aria-labelledby="modalProductosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductosLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-producto" action="" method="POST" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <div id="editarProducto">
            <div class="row">
                <input type="hidden" name="producto-id" id="producto-id">
                <input type="hidden" name="producto-fotosBorrar" id="producto-fotosBorrar">
                <div class="col-12 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="producto-nombre">Nombre</label>
                        <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required value="<?php echo e(old('producto-nombre')); ?>">
                    </div>    
                    <div class="form-group">
                        <label for="producto-descripcion">Descripción</label>
                        <textarea class="form-control" style="height:125px;" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3"><?php echo e(old('producto-descripcion')); ?></textarea>
                    </div>  
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
                        <label for="producto-modelo">Modelo</label>
                        <input type="text" class="form-control" name="producto-modelo" id="producto-modelo" placeholder="Modelo" rows="3"><?php echo e(old('producto-modelo')); ?></input>
                    </div>  
                    <div class="form-group">
                        <label for="producto-stock">Stock</label>
                        <div class="input-group form-group">
                            <input type="number" class="form-control" min="0" name="producto-stock" id="producto-stock" placeholder="Stock" required step="1">
                        </div>  
                    </div>
                </div>
                <div class="col-12 col-md-6 col-sm-6">
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
                        <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria2">
                            <option value="">Sin subcategoria</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="producto-precio">Precio</label>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="number" class="form-control" name="producto-precio" id="producto-precio" placeholder="Precio" required min="0" step=".01">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="producto-foto">Selecciona Imágen...</label>
                        <input type="file" class="form-control" multiple name="producto-foto[]" id="producto-foto" required style="padding: 0;">
                    </div> 
                    <div class="form-group">
                        <label for="producto-atributos">Atributos</label>
                        <textarea class="form-control" name="producto-atributos" id="producto-atributos" placeholder="Atributos" rows="3"><?php echo e(old('producto-atributos')); ?></textarea>
                    </div>  
                </div>
            </div>
            <a class="" data-toggle="collapse" href="#modal-form-fotos" role="button" aria-expanded="true" aria-controls="modal-form-fotos">
              Modificar fotos
            </a> 
            <div id="modal-form-fotos" class="collapse" aria-labelledby="headingOne" data-parent="#editarProducto" style="position: relative;">
            </div>
          </div>
          <div id="borrarProducto">
          
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-producto').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>