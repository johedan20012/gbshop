<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href=" <?php echo e(asset('css/producto.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
<?php echo e($producto->nombre); ?>| GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container">
    <div class="product_wrap">
        <?php echo $__env->make('widgets.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
            <div class="accordion" id="accordionMensualidades">                                      
                <h5 class="mb-0">
                    <i class="fa fa-money-check-alt"></i>
                    <a data-toggle="collapse" href="#collapseTree" role="button" aria-expanded="true" aria-controls="collapseTree">                                                                                        
                        Ver mensualidades
                    </a>
                </h5>                                        
                <div id="collapseTree" class="collapse" aria-labelledby="headingTree" data-parent="#accordionMensualidades">
                    <label>T. Crédito:</label>
                    <select>
                        <option value="amex">American Express</option>
                        <option value="master">Master Card</option>
                        <option value="visa">Visa</option>
                    </select>  
                    <br>
                    <label>Banco:</label>
                    <select>
                        <optgroup data-id="1" label="Hasta 1 cuotas sin interés">
                            <option value="158" data-max-installments="1">Bancomer</option>
                            <option value="160" data-max-installments="1">Santander</option>
                            <option value="159" data-max-installments="1">Citibanamex</option>
                            <option value="163" data-max-installments="1">Banorte</option>
                            <option value="164" data-max-installments="1">HSBC</option>
                            <option value="165" data-max-installments="1">Scotiabank</option>
                            <option value="1022" data-max-installments="1">Banregio</option>
                            <option value="1018" data-max-installments="1">Banco Ahorro Famsa</option>
                            <option value="1024" data-max-installments="1">Mifel</option>
                            <option value="1023" data-max-installments="1">Inbursa</option>
                            <option value="1021" data-max-installments="1">Bajio</option>
                            <option value="1020" data-max-installments="1">Ixe</option>
                            <option value="1019" data-max-installments="1">Invex</option>
                            <option value="1017" data-max-installments="1">Afirme</option>
                            <option value="1039" data-max-installments="1">Banco Azteca</option>
                            <option value="1046" data-max-installments="1">Bancoppel</option>
                        </optgroup>
                        <optgroup label="Otros bancos" data-id="0">
                            <option value="other">Otro</option>
                        </optgroup>
                    </select>
                    <label>Mensualidad:</label>
                    <select>
                        <option value="34">1 pago de <strong class="money2">$1,850.00</strong></option>
                        <option value="35">3 pagos de $653.61</option>
                        <option value="36">6 pagos de $338.36</option>
                        <option value="37">12 pagos de $182.76</option>
                        <option value="38">18 pagos de $130.19</option>
                    </select>
                </div>
            </div> 
            <br>
            <div class="accordion" id="accordionCostos">                                      
                <h5 class="mb-0">
                    <i class="fa fa-truck"></i>
                    <a data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">                                                                                        
                        Ver costos de envío
                    </a>
                </h5>                                        
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionCostos">
                        <table class="envios-tabla">
                            <thead>
                                <tr>
                                    <th>Forma de Envío</th>
                                    <th>Costo</th>
                                    <th>Entrega Estimada</th>
                                </tr>
                            </thead>
                            <tbody id="opciones">
                                <tr>
                                    <td>
                                        Envíos Gratis Compra Min. $800
                                    </td>
                                    <td>
                                        <span class="texto-promo">Envío gratis</span>
                                    </td>
                                    <td>
                                        Martes&nbsp;
                                        <strong class="dia-entrega">27 de Agosto </strong>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        Compras inferiores a $800
                                    </td>
                                    <td>
                                        <span class="envio-precio">$ 150.00</span>
                                    </td>
                                    <td>
                                        Miércoles&nbsp;
                                        <strong class="dia-entrega">28 de Agosto </strong>
                                    </td>
                                </tr>   
                                <tr>
                                    <td>
                                        A convenir
                                    </td>
                                    <td colspan="2">
                                        <span class="envio-precio">Acuerdas la forma de entrega del producto después de la compra.</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
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