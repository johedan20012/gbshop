<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/producto.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
<?php echo e($producto->nombre); ?>| GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container">
    <?php if(Session::has('Mensaje') || Session::has('Error') || Session::has('Warning')): ?>
        <div class="toast" id="myToast" data-delay="6000" style="max-width: none;">
            <div class="toast-header">
                <strong class="mr-auto"><i class="fas fa-info-circle"></i>Mensaje de GBRoute</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                <?php if(Session::has('Mensaje')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(Session::get('Mensaje')); ?>

                    </div>
                <?php elseif(Session::has('Error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo e(Session::get('Error')); ?>

                    </div>
                <?php elseif(Session::has('Warning')): ?>
                <div class="alert alert-warning" role="alert">
                        <?php echo e(Session::get('Warning')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="product_wrap">
        <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
        <div id="product_image_container" class="col-md-6">
            
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php if($producto->stock <= 0): ?>
                        <picture>
                            <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/agotado.webp')); ?>">
                            <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>">
                            <img src="<?php echo e(asset('storage/imagenesLayout/agotado.png')); ?>" style="position: absolute; z-index : 2; width: 40%;" >
                        </picture>
                    <?php endif; ?>
                    <?php $iteracion = 0; $bandera = 0;?>
                    <?php $__currentLoopData = $producto->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $fotoProducto = pathinfo($foto->nombre, PATHINFO_FILENAME); ?>
                        <?php if($bandera == 0): ?>
                            <div class="carousel-item active dimensiones">
                        <?php else: ?>
                            <div class="carousel-item dimensiones">
                        <?php endif; ?>
                                <picture>
                                    <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp')); ?>">
                                    <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>">
                                    <img src="<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>" class="d-block imagenCarrusel" alt="...">
                                </picture>
                            </div>
                        <?php $iteracion += 1; $bandera = 1;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a class="carousel-control-prev controlCarrusel" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next controlCarrusel" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
                <div class="row">
                    <?php $iteracion = 0;?>
                    <?php $__currentLoopData = $producto->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $fotoProducto = pathinfo($foto->nombre, PATHINFO_FILENAME); ?>
                        <div class="col-md-3 col-sm-2 col-3">
                            <a href="#" data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($iteracion); ?>" class="active">
                                <div class="dimensiones-mini">
                                    <picture>
                                        <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesProductos/webp/'.$fotoProducto.'.webp')); ?>">
                                        <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>">
                                        <img src="<?php echo e(asset('storage/imagenesProductos/'.$fotoProducto.'.png')); ?>" class="d-block imagenCarrusel" alt="...">
                                    </picture>
                                </div>
                            </a>
                        </div>
                        <?php $iteracion += 1;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
        </div>
        
        <div class="col-md-6">
            <h7><?php echo e($producto->nombre); ?></h7>
            <br>
            <h7 id="producto-marca" ><?php echo e($producto->marca->nombre); ?></h7>
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
                <picture>
                    <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/visa-american-express-mastercard.webp')); ?>">
                    <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')); ?>">
                    <img src="<?php echo e(asset('storage/imagenesLayout/visa-american-express-mastercard.jpg')); ?>" width="30%">  
                </picture>
                <picture>
                    <source type="image/webp" srcset = "<?php echo e(asset('storage/imagenesLayout/webp/OXXO.webp')); ?>">
                    <source type="image/png" srcset = "<?php echo e(asset('storage/imagenesLayout/OXXO.png')); ?>">
                    <img src="<?php echo e(asset('storage/imagenesLayout/OXXO.png')); ?>" width="10%">
                </picture>
                <!--<img src="<?php echo e(asset('storage/imagenesLayout/7ELEVEN.png')); ?>" width="7%"> -->
                <!--<img src="<?php echo e(asset('storage/imagenesLayout/EXTRA.PNG')); ?>" width="17%">  -->                        
            </div>
            <br>
            <div class="accordion" id="accordionCostos">                                      
                <h5 class="mb-0">
                    <i class="fa fa-truck"></i>
                    <span data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">                                                                                        
                        Costo de envío en la Republica Mexicana <span class="texto-promo">(Envío gratis)</span>
                    </span>
                </h5>   
            </div>
            <br>
            <?php if($producto->stock > 0): ?>
                <label class = "">Disponibilidad:</label>
                <span class="text-success">En existencia</span> 

                <form action="<?php echo e(route('addCarrito')); ?>" enctype="multipart/form-data" role="form" method="post">
                    <?php echo e(csrf_field()); ?>

                    <span>Cantidad: <input min="1" type="number" name="cantidad" value="1" style="width:60px; height:27px; text-align: center;margin: 5px 10px;"></span>
                    <br><br><br>
                    <input type="hidden" value="<?php echo e($producto->codigo); ?>" name="codigo">
                    <button type="submit" class="btn btn-danger">COMPRAR <i class="fa fa-shopping-cart"></i></button>
                </form>
            <?php else: ?>
                <span class="text-danger">Producto agotado</span>                
            <?php endif; ?>
        </div>
        <div id="descripcion" class="col-md-12 clear">
            <?php if($producto->atributos != ""): ?>
            <div class="row esp-producto-contenedor col-md-12">
                <header class="esp-producto-header">
                    <h4>Especificaciones del producto</h4>
                </header>
                <section class="esp-producto-section">
                    <?php $AtributosProducto = json_decode($producto->atributos);?>
                    <?php $__currentLoopData = $AtributosProducto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nombre=>$valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row">
                            <div class="col-sm-4"><?php echo e($nombre); ?></div>
                            <div class="col-sm-8" ><?php echo e($valor); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </section>   
            </div>
            <?php endif; ?>
        </div>
        </div> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/producto.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>