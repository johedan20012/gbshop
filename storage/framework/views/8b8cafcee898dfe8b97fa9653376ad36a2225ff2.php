<?php echo $productos->links('widgets.pagination'); ?>

<ul class="list-group">
    <?php if(isset($actual)): ?>  
        <input type="hidden" id="categoria-actual" value="<?php echo e($actual); ?>">  
    <?php else: ?>
        <input type="hidden" id="categoria-actual" value=""> 
    <?php endif; ?>
    <?php if(isset($actual2)): ?>  
        <input type="hidden" id="cadena-actual" value="<?php echo e($actual2); ?>">  
    <?php else: ?>
        <input type="hidden" id="cadena-actual" value=""> 
    <?php endif; ?>

    <?php if(count($productos) == 0): ?>
        No se encontraron productos con los datos solicitados.
    <?php endif; ?>
    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item list-group-item-action flex-column align-items-start" style="padding: 0">
            <div class="d-flex w-100 justify-content-between">
                
                <div class="image-parent col-md-2 col-2" style="padding:5px;">
                    <?php if(isset($producto->foto)): ?>
                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" style="height:100%; width:100%;">
                            <div style="height:100%; width:100%;">
                                <div class="dimensiones2" style="background: url(<?php echo e(asset('storage/imagenesProductos/'.$producto->foto->nombre)); ?>) no-repeat  center; background-size: contain;"> </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="text-left mr-auto col-md-8 col-8 pr-1 pt-4 pb-4 pl-1 p-m-6">
                    <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" title="<?php echo e($producto->nombre); ?>" target="_self"><?php echo e($producto->nombre); ?></a>
                </div>

                <span class="price-item ms-price ms-search-result_item-price col-md-2 col-2 pb-4 pt-4 pr-1 pl-1 p-md-2">
                    <div id="product_price" class="money">
                        <span class="money">$<?php echo e($producto->precio); ?></span>
                    </div>          
                </span>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php echo $productos->links('widgets.pagination'); ?>