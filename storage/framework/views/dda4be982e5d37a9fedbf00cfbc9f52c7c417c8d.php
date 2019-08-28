<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/catalogo.css')); ?>" type="text/css"> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
  <?php if(isset($breadcrumb) && $breadcrumb != null): ?>
    <?php $titulo=""?>
    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hoja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $titulo .= ' '.$hoja['nombre']?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($titulo); ?> | GB Route Music Store: Tienda online
  <?php else: ?>
    Catalogo | GB Route Music Store: Tienda online
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
  <br><hr>
  <div class="d-flex justify-content-center">
    <div class ="row col-md-11 pl-md-2">
        <div class="col-md-4">
          <?php echo $__env->make('widgets.sidebarCategorias', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-md-8">
          <div class="col-md-12" id="breadcr">
            <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
          <div class="col-md-12" id="paginador">
            <?php echo $__env->make('widgets.tablaProductos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script src="<?php echo e(asset('js/catalogo.js')); ?>"></script>
  <input type="hidden" value="<?php echo e(route('buscarProductos')); ?>" id="rutaProductos">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>