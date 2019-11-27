<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $pedidos->links('widgets.pagination'); ?>

    </div>

    <form class="form-inline mr-3" id="buscarPedido" action="">          
        <?php if(isset($actual)): ?>  
            <input type="search" class="form-group" name="pedido-busca" id="pedido-busca" placeholder="Buscar" value="<?php echo e($actual); ?>"> 
        <?php else: ?>
            <input type="search" class="form-group" name="pedido-busca" id="pedido-busca" placeholder="Buscar"> 
        <?php endif; ?>            
                               
        <i class="fa fa-search"></i>
    </form>

    <?php if(isset($actual)): ?>  
        <input type="hidden" id="pedido-actual" value="<?php echo e($actual); ?>">  
    <?php else: ?>
        <input type="hidden" id="pedido-actual" value=""> 
    <?php endif; ?>
    
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Fecha creación</th>
    <th scope="col">Clave</th>
    <th scope="col">Subtotal</th>
    <th scope="col">Costo envio</th>
    <th scope="col">Costo meses</th>
    <th scope="col">Total</th>
    <th scope="col">Estatus</th>
    <th scope="col">Comentarios</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    <?php if(count($pedidos) == 0): ?>
        No se encontraron marcas con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td><?php echo e($pedido->created_at); ?></td>
        <td class="pedido-clave"><?php echo e($pedido->clave); ?></td>
        <td><?php echo e($pedido->subtotal); ?></td>
        <td><?php echo e($pedido->costo_envio); ?></td>
        <td><?php echo e($pedido->costo_meses); ?></td>
        <td><?php echo e($pedido->total); ?></td>
        <td>
            <?php if($pedido->estatus == 1): ?>
                Pendiente
            <?php elseif($pedido->estatus == 2): ?>
                Pagado
            <?php elseif($pedido->estatus == 3): ?>
                En proceso de envio
            <?php elseif($pedido->estatus == 4): ?>
                Enviado
            <?php else: ?>
                Cancelado
            <?php endif; ?>
        </td>
        <td><textarea rows="3" cols="10" disabled><?php echo e($pedido->comentarios); ?></textarea></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalPedidos" data-clave="<?php echo e($pedido->clave); ?>" data-type="1" data-estatus="<?php echo e($pedido->estatus); ?>"><i class="fa fa-edit" style="color:blue"> </i> Modificar estatus</button>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo e(route('hojaPedido')); ?>?clavePedido=<?php echo e($pedido->clave); ?>&ver=1" target="_blank"><i class="fas fa-search" style="color: blue"> </i> Ver detalles</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo e(route('hojaPedido')); ?>?clavePedido=<?php echo e($pedido->clave); ?>"><i class="fas fa-file-download" style="color: blue"> </i> Descargar hoja de pedido</a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalPedidos" data-clave="<?php echo e($pedido->clave); ?>" data-type="3"><i class="fas fa-redo-alt" style="color: blue"> </i> Reenviar correo</button>
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

<div class="modal fade" id="modalPedidos" tabindex="-1" role="dialog" aria-labelledby="modalPedidosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalPedidosLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
        </div>    
        <div class="modal-footer">
            <button type="button" id="modal-boton1" class="btn btn-secondary" data-dismiss="modal"></button>
            <button type="button" id="modal-boton2" onclick="procesarModal($('#modalPedidos'));"class="btn btn-primary"></button>
        </div>
        <input type="hidden" id="modal-tipo">
        <input type="hidden" id="modal-clave">
    </div>
  </div>
</div>