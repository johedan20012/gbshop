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
        <td class="nombre-producto"><?php echo e($producto->nombre); ?></td>
        <td class="descripcion-producto"><textarea rows="4" cols="50" disabled><?php echo e($producto->descripcion); ?></textarea></td>
        <td class="marca-producto"><?php echo e($producto->marca->nombre); ?></td>
        <td class="categoria-producto"><?php echo e($producto->categoria->nombre); ?></td>
        <td class="precio-producto">$<?php echo e($producto->precio); ?></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#modalCategorias" ><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#modalCategorias" ><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
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

<div class="modal fade" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="modalCategoriasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCategoriasLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-categoria" action="" method="POST" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" class="form-control" name="categoria-id" id="categoria-id">
          <div class="form-group" id="div-categoria-nombre">
            <label for="message-text" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="categoria-nombre" id="categoria-nombre">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-categoria').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>