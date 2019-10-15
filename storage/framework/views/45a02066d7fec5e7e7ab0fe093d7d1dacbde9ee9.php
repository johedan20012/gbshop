<nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="directorio">
        <li class="breadcrumb-item" id="breadcrum-init"><a href="<?php echo e(route('inicio')); ?>">GB Route Music Store</a></li>
        
        <?php if(isset($breadcrumb) && $breadcrumb != null): ?>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($hoja['ruta'] == ""): ?>
                    <li class="breadcrumb-item active" id="last-categoria" aria-current="page"><?php echo e($hoja['nombre']); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item" id="breadcrum-init"><a href="<?php echo e($hoja['ruta']); ?>"><?php echo e($hoja['nombre']); ?></a></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- <li class="breadcrumb-item active" aria-current="page">Otros</li> -->
        <?php endif; ?>
    </ol>
</nav>