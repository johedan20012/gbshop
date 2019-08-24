<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $marcas1->links('widgets.pagination'); ?>

    </div>

    <form class="form-inline mr-3" id="buscarMarca" action="">          
        <?php if(isset($actual)): ?>  
            <input type="search" class="form-group" name="marca-busca" id="marca-busca" placeholder="Buscar" value="<?php echo e($actual); ?>"> 
        <?php else: ?>
            <input type="search" class="form-group" name="marca-busca" id="marca-busca" placeholder="Buscar"> 
        <?php endif; ?>            
                               
        <i class="fa fa-search"></i>
    </form>

    <?php if(isset($actual)): ?>  
        <input type="hidden" id="marca-actual" value="<?php echo e($actual); ?>">  
    <?php else: ?>
        <input type="hidden" id="marca-actual" value=""> 
    <?php endif; ?>
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    <?php if(count($marcas1) == 0): ?>
        No se encontraron marcas con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $marcas1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td class="nombre-marca"><?php echo e($marca->nombre); ?></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-8 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarMarcas" data-id="<?php echo e($marca->idmarcas); ?>" data-nombre="<?php echo e($marca->nombre); ?>"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalBorrarMarcas" data-id="<?php echo e($marca->idmarcas); ?>" data-nombre="<?php echo e($marca->nombre); ?>"><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
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

<div class="modal fade" id="modalEditarMarcas" tabindex="-1" role="dialog" aria-labelledby="modalEditarMarcasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarMarcasLabel">Modificar marca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-editMarca" action="<?php echo e(route('editMarca')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" class="form-control" name="marca-id" id="marca-id">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="marca-nombre" id="marca-nombre">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-editMarca').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalBorrarMarcas" tabindex="-1" role="dialog" aria-labelledby="modalBorrarMarcasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBorrarMarcasLabel">Eliminar marca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-delMarca" action="<?php echo e(route('delMarca')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" class="form-control" name="marca-id" id="marca-id">
          <label for="message-text" id="message-modalMarcas" class="col-form-label"></label>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-delMarca').submit()"class="btn btn-primary">Eliminar</button>
      </div>
    </div>
  </div>
</div>
