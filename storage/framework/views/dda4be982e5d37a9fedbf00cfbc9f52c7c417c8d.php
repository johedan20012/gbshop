<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/catalogo.css')); ?>" type="text/css"> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
  <br><hr>
  <div class="d-flex justify-content-center">
    <div class ="row col-md-11 pl-md-2">
        <div class="col-md-4">
          <ul class="sidenav list-group">
              <li class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                      <div class="row col-md-12">
                          <div class="col-md-11 pl-md-1">
                            <a class="d-inline categoria" href="" title="Todos" target="_self" nombreCat="">Todos
                              <input type="hidden" value="0">
                            </a>
                          </div>
                      </div>
                  </div>              
              </li>
              <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 justify-content-between">
                          <div class="row col-md-12">
                              <div class="col-md-11 pl-md-1">
                                <a class="d-inline categoria" href="" title="<?php echo e($categoria->nombre); ?>" target="_self" nombreCat="<?php echo e($categoria->nombre); ?>"><?php echo e($categoria->nombre); ?>

                                  <input type="hidden" value="<?php echo e($categoria->idcategorias); ?>">
                                </a>
                              </div>
                              <?php if(count($categoria->subCategorias) ): ?>
                                <button class="dropdown-btn  col-md-1">
                                  <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-container">
                                  <?php $__currentLoopData = $categoria->subCategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="categoria subCategoria" href="#" nombreCat="<?php echo e($categoria->nombre); ?>" nombreSubCat="<?php echo e($subCategoria->nombre); ?>" idCat="<?php echo e($categoria->idcategorias); ?>"><?php echo e($subCategoria->nombre); ?>

                                      <input type="hidden" value="<?php echo e($subCategoria->idcategorias); ?>">
                                    </a>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                              <?php endif; ?>
                          </div>
                      </div>              
                  </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
        <div class="col-md-8">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb" id="directorio">
              <li class="breadcrumb-item" id="breadcrum-init"><a href="#">GB Shop Music Store</a></li>
              
              <!-- <li class="breadcrumb-item active" aria-current="page">Otros</li> -->
            </ol>
          </nav>
          <div class="col-md-12" id="paginador">
            <?php echo $__env->make('tablaProductos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script src="<?php echo e(asset('js/inicio.js')); ?>"></script>
  <input type="hidden" value="<?php echo e(route('productosPorCategoria')); ?>" id="rutaProductos">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>