<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $marcas->links('widgets.pagination'); ?>

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
    <?php if(count($marcas) == 0): ?>
        No se encontraron marcas con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td class="nombre-marca"><?php echo e($marca->nombre); ?></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-8 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalMarcas" data-type="1" data-id="<?php echo e($marca->idmarcas); ?>" data-nombre="<?php echo e($marca->nombre); ?>"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalMarcas" data-type="2" data-id="<?php echo e($marca->idmarcas); ?>" data-nombre="<?php echo e($marca->nombre); ?>"><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
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

<div class="modal fade" id="modalMarcas" tabindex="-1" role="dialog" aria-labelledby="modalMarcasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMarcasLabel">Modificar marca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-marca" action="" method="POST" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" class="form-control" name="marca-id" id="marca-id">
          <div class="form-group" id="div-marca-nombre">
            <label for="message-text" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="marca-nombre" id="marca-nombre">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-marca').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>


