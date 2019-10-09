<ul class="sidenav list-group">
    <li class="list-group-item list-group-item-action list-group-item-secondary flex-column align-items-start" style="background: black; border: 1px solid lightgray;">
        <div class="d-flex w-100 justify-content-between">
            <div class="row col-md-12 pl-1">
                <div class="col-md-11 pl-md-1 col-11 pl-1">
                    <a class="text-uppercase d-inline pl-0 categoria text-white" style="FONT-WEIGHT: BOLDER;" href="<?php echo e(route('catalogo')); ?>" title="Todos" target="_self" nombreCat="">Todos
                        <input type="hidden" value="0">
                    </a>
                </div>
            </div>
        </div>              
    </li>
    <?php if(isset($categorias) && $categorias != null): ?>
        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item list-group-item-action list-group-item-secondary flex-column align-items-start" style="background: black; border: 1px solid lightgray;">
                <div class="d-flex w-100 justify-content-between">
                    <div class="row col-md-12 pl-1">
                        <div class="col-md-11 pl-md-1 col-11 pl-1">
                            <a class="text-uppercase d-inline pl-0 list-group-item-secondary text-white categoria" style="FONT-WEIGHT: BOLDER;" href="<?php echo e(route('catalogo').'?id='.$categoria->idcategorias); ?>" title="<?php echo e($categoria->nombre); ?>" target="_self" nombreCat="<?php echo e($categoria->nombre); ?>"><?php echo e($categoria->nombre); ?>

                                <input type="hidden" value="<?php echo e($categoria->idcategorias); ?>">
                            </a>
                        </div>
                        <?php if(count($categoria->subCategorias) ): ?>
                        <button class="dropdown-btn pl-md-2 pr-md-2 col-md-1 col-1 pl-2 pr-2">
                            <i class="fa fa-caret-down" style="color: #dc3545;"></i>
                        </button>
                        <div class="dropdown-container">
                            <?php $__currentLoopData = $categoria->subCategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="categoria subCategoria text-white" href="<?php echo e(route('catalogo').'?id='.$subCategoria->idcategorias); ?> " nombreCat="<?php echo e($categoria->nombre); ?>" nombreSubCat="<?php echo e($subCategoria->nombre); ?>" idCat="<?php echo e($categoria->idcategorias); ?>"><?php echo e($subCategoria->nombre); ?>

                                <input type="hidden" value="<?php echo e($subCategoria->idcategorias); ?>">
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>              
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</ul>