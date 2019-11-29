<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $pedidos->links('widgets.pagination'); ?>

    </div>
    
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Fecha creación</th>
    <th scope="col">Clave</th>
    <th scope="col">Total</th>
    <th scope="col">Estatus</th>
    <th scope="col">Detalles</th>
    </tr>
</thead>
<tbody>
    <tr>
    <?php if(count($pedidos) == 0): ?>
        No se encontraron pedidos con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td><?php echo e($pedido->created_at); ?></td>
        <td class="pedido-clave"><?php echo e($pedido->clave); ?></td>
        <td><?php echo e($pedido->total); ?></td>
        <td>
            <?php if($pedido->estatus == 1): ?>
                En espera del pago
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
        <td>
            <a class="dropdown-item" href="<?php echo e(route('hojaPedidoCliente')); ?>?clavePedido=<?php echo e($pedido->clave); ?>" target="_blank"><i class="fas fa-eye" style="color: blue"> </i> Ver detalles</a>
        </td>
        </tr>
        <tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tr>
</tbody>
</table>