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
            <div class="m-0 col-md-12">
                <div class="row">
                    <div class="image-parent col-md-4 col-4 pb-md-1" style="padding:0px;">
                        <?php if($producto->stock <= 0): ?>
                            <img src="<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>" style="position: absolute; z-index : 2; width: 45%;" >
                        <?php endif; ?>
                        <?php if(isset($producto->foto)): ?>
                            <?php $fotoProducto = pathinfo($producto->foto->nombre, PATHINFO_FILENAME); ?>
                            <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" style="height:100%; width:100%; position: absolute; left: 0px;">
                                <div class = "dimensiones2" style="padding:15px;">
                                    <div class = "contImgProducto">
                                        <picture>
                                            <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp')); ?>">
                                            <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>">
                                            <img src="<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>" class="d-block w-100" alt="...">
                                        </picture>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-left mr-auto col-md-8 col-8 pt-5 pb-3 pl-1 pr-1 pt-md-5 pb-md-5">
                        <a href="<?php echo e(route('verProducto').'?code='.$producto->codigo); ?>" title="<?php echo e($producto->nombre); ?>" target="_self"><?php echo e($producto->nombre); ?></a>
                        <div class="row" style="padding-left:15px;">
                            <?php if($producto->stock > 0): ?>
                                <label class = "">Disponibilidad:</label>
                                <span class="text-success" style="padding-left:10px;">En existencia</span> 
                            <?php else: ?>
                                <span class="text-danger">Producto agotado</span>                
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <span class="price-item ms-price ms-search-result_item-price text-right col-md-12 col-12 pr-1 pl-1 pr-md-2">
                        <div id="product_price" class="money">
                            <span class="money">$<?php echo e($producto->precio); ?></span>
                        </div>          
                    </span>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php echo $productos->links('widgets.pagination'); ?>