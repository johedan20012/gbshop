<?php $__env->startSection("css"); ?>
    ##parent-placeholder-2f84417a9e73cead4d5c99e05daff2a534b30132##
    <link rel="stylesheet" href=" <?php echo e(asset('css/auth/panelBanners.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('nav-tab'); ?>
<div class="tab-pane fade show active" id="nav-banners" role="tabpanel" aria-labelledby="nav-banners-tab ">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
            <br>
            <div id="ver-banners">
                <button data-toggle="modal" data-target="#modalBanners" class="btn btn-danger" style="float: right;position: absolute;z-index: 9;right: 0;"> Eliminar</button>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php $cont = 0; ?>
                        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($cont == 0): ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($cont); ?>" class="active"></li>
                            <?php else: ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($cont); ?>"></li>
                            <?php endif; ?>
                            <?php $cont +=1?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php $cont = 0; ?>
                        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($cont == 0): ?>
                                <div class="carousel-item active" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                                    <img src="<?php echo e(asset('storage/imagenesLayout/banners/'.$banner)); ?>" class="d-block w-100" alt="...">
                                </div>
                            <?php else: ?>
                                <div class="carousel-item" data-id="<?php echo e($cont); ?>" data-nombre="<?php echo e($banner); ?>">
                                    <img src="<?php echo e(asset('storage/imagenesLayout/banners/'.$banner)); ?>" class="d-block w-100" alt="...">
                                </div>
                            <?php endif; ?>
                            <?php $cont +=1?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div> 
            </div>
        </div>  
        <div class="col-md-6 col-sm-6 col-12">
            <br>
            <div id="add-banner">
                <h4 aling="center" class="titulo">
                    <i class="fa fa-plus"></i>
                    Agregar banner
                </h4>
                <form role="form" action="<?php echo e(route('storeBanner')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <label for="banner-fotos">Selecciona Imágen...(4MB maximo por cada imagen )</label>
                        <input type="file" class="form-control" multiple name="banner-fotos[]" id="banner-fotos" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Agregar banner(s)</button>                                                      
                </form>
            </div>
        </div>
    </div>  
</div>

<!--Modales-->

<div class="modal fade" id="modalBanners" tabindex="-1" role="dialog" aria-labelledby="modalBannersLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBannersLabel">Eliminar banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-banner" action="<?php echo e(route('delBanner')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" class="form-control" name="banner-nombre" id="banner-nombre">
            <div class="form-group" id="div-banner-mensaje"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-banner').submit()"class="btn btn-primary">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <input type="hidden" value="" id="rutaDelCategoria">
    <script src="<?php echo e(asset('js/admin/tabBanners.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>