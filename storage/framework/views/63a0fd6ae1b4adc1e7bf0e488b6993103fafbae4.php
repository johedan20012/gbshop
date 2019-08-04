<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/producto.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
<?php echo e($producto->nombre); ?>| GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container">
    <div class="product_wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" title="Volver a Inicio">GB Route Music Store</a></li>
                <li class="breadcrumb-item"><a href="#" title="Guitarras">Guitarras</a></li>
                <li class="breadcrumb-item"><a href="#" title="Ukuleles, Banjos y Mandolinas">Ukuleles, Banjos Y Mandolinas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ukelele La Sevillana Mod. Svuke-100</li>
            </ol>
            </nav>
        <div class="row">
        <div id="product_image_container" class="col-md-5">
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <?php $iteracion = 0; $bandera = 0;?>
                    <?php $__currentLoopData = $producto->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($bandera == 0): ?>
                            <div class="carousel-item active">
                        <?php else: ?>
                            <div class="carousel-item">
                        <?php endif; ?>
                            <img src="<?php echo e(asset('storage/imagenesProductos/'.$foto->nombre)); ?>" class="d-block w-100" title="Imagen <?php echo e($iteracion); ?>">
                        </div>
                        <?php $iteracion += 1; $bandera = 1;?>
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
                <div class="row">
                    <?php $iteracion = 0;?>
                    <?php $__currentLoopData = $producto->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-sm-2 col-3">
                            <a href="#" data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($iteracion); ?>" class="active">
                                <img src="<?php echo e(asset('storage/imagenesProductos/'.$foto->nombre)); ?>" class="img-thumbnail" title="Imagen <?php echo e($iteracion); ?>">
                            </a>
                        </div>
                        <?php $iteracion += 1;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
        </div>
        
        <div class="col-md-7">
            <h7><?php echo e($producto->nombre); ?></h7>
            <br>
            
            <div id="product_price" >
                <!-- sin descuento -->
                <span class="money">
                    $ <?php echo e($producto->precio); ?>

                </span>
                <br><br>
            </div>
            <i class="fa fa-credit-card" style="font-size: 34px;"></i>
            <span>Paga en Meses con</span>
            <br>
            <div style="padding-left: 40px; padding-top: 10px;"> 
                <img src="<?php echo e(asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')); ?>" width="30%">  
                <img src="<?php echo e(asset('storage/imagenesLayout/OXXO.png')); ?>" width="10%">
                <img src="<?php echo e(asset('storage/imagenesLayout/7ELEVEN.png')); ?>" width="7%">
                <img src="<?php echo e(asset('storage/imagenesLayout/EXTRA.PNG')); ?>" width="17%">                          
            </div>
            
            <span style="padding-left: 40px;"><a href="#">ver Mensualidades</a></span> 
            <br><br><br>
            <i class="fa fa-truck" style="font-size: 34px;"></i>
                <span><a href="#">Ver costos de envío</a></span>
            <br>
            <br>
            <br>
            <span>Cantidad: <input min="1" type="number" value="1" max="1" style="width:60px; height:27px; text-align: center;margin: 5px 10px;"></span>
            <br><br><br>
            <button type="submit" class="btn btn-danger">COMPRAR <i class="fa fa-shopping-cart"></i></button>
        </div>
        <div id="descripcion" class="col-xs-12 clear">
            <h4>Descripción</h4>
            <pre><?php echo e($producto->descripcion); ?></pre>
        </div>
        </div> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>