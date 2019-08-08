<?php echo $productos->links('widgets.pagination'); ?>

<ul class="list-group">
    <?php if(count($productos) == 0): ?>
        No se encontraron productos con los datos solicitados.
    <?php endif; ?>
    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                
                <div class="image-parent">
                    <?php if(isset($producto->foto)): ?>
                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>">
                            <img class="img-fluid" width="100px" height="100px" src="<?php echo e(asset('storage/imagenesProductos/'.$producto->foto->nombre)); ?>" alt="" title=""></a>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="text-left mr-auto">
                    <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" title="<?php echo e($producto->nombre); ?>" target="_self"><?php echo e($producto->nombre); ?></a>
                </div>

                <span class="price-item ms-price ms-search-result_item-price">
                    <div id="product_price" class="money">
                        <span class="money">$ <?php echo e($producto->precio); ?></span>
                    </div>          
                </span>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<!-- Id cat paginador-->
<input type="hidden" id="paginador-idCat" value="<?php echo e($idcategoria); ?>">

<?php echo $productos->links('widgets.pagination'); ?>