<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/cliente/panel.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('titulo'); ?>
GB Route Music Store: Tienda online
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<header class="header-tienda">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-xs-12">
                <a href="<?php echo e(route('inicio')); ?>">
                    <img src="<?php echo e(asset('storage/imagenesLayout/logo.png')); ?>"  alt="Gb Shop">
                </a>
            </div>
            <div class="col-12 col-md-6 col-xs-12 text-center abajo">
                <ul class="lista-inline">
                    <br>
                    <li class="">
                        <i class="fas fa-lock rojo-red"></i>
                        Pago seguro y fácil
                    </li>
                    <li class="">
                        <i class="fas fa-shipping-fast rojo-red"></i>
                        Tu pedido en la fecha programada
                    </li>
                </ul>
            </div>
        </div>
    </div>  
</header>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('contenido'); ?>

<div class="container">
    <div class="row"> 
        <div class="col-md-3 m-t-10 text-center ">
            <div class="m-t-10 ">Su información</div><br>
            <div class="m-t-10 m-b-20">Historial de compras</div>
        </div>           
        <div class="col-md-9 m-t-10 ">
            <h3>Bienvenido, <strong class="rojo-red">Nombre del Cliente</strong></h3>
            <hr>    
            <h5>Mis Datos</h5> 
            <hr>
            <form role="form" action="" method="POST" enctype="multipart/form-data">
                <div class="row noval">
                    <div class="col-12 col-md-6 col-sm-6" style="font-size:smaller">
                        <div class="form-group">
                            <label for="cliente-nombreCompleto">Nombre Completo</label>
                            <input type="text" class="form-control" name="cliente-nombreCompleto" id="cliente-nombreCompleto" placeholder="Nombre Completo" required >
                        </div> 
                        <div class="form-group">
                            <label for="cliente-aPaterno">Apellido Paterno</label>
                            <input type="text" class="form-control" name="cliente-aPaterno" id="cliente-aPaterno" placeholder="Apellido Paterno" required >
                        </div>
                        <div class="form-group">
                            <label for="cliente-aMaterno">Apellido Materno</label>
                            <input type="text" class="form-control" name="cliente-aMaterno" id="cliente-aMaterno" placeholder="Apellido Materno" required >
                        </div>
                        <div class="form-group">
                            <label for="cliente-email">Dirección de E-Mail</label>
                            <input type="text" class="form-control" name="cliente-email" id="cliente-email" placeholder="Dirección de Email" required >
                        </div> 
                    </div>
                    <div class="col-12 col-md-6 col-sm-6" style="font-size:smaller">
                        <div class="form-group">
                            <label for="cliente-calle">Calle</label>
                            <input type="text" class="form-control" name="cliente-calle" id="cliente-calle" placeholder="Calle" required >
                        </div>
                        <div class="form-group">
                            <label for="cliente-entreCalle">Entre Calle</label>
                            <input type="text" class="form-control" name="cliente-entreCalle" id="cliente-entreCalle" placeholder="Entre Calle" >
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4 col-md-4">
                                <label for="cliente-nExt">Número Exterior</label>
                                <input type="number" class="form-control" name="cliente-nExt" id="cliente-nExt" placeholder="Número Exterior" required>
                            </div> 
                            <div class="form-group col-4 col-md-4">
                                <label for="cliente-nInt">Número Interior</label>
                                <input type="number" class="form-control" name="cliente-nInt" id="cliente-nInt" placeholder="Número Interior" required>
                            </div> 
                            <div class="form-group col-4 col-md-4">
                                <label for="cliente-cp">Código Postal</label>
                                <input type="number" class="form-control" name="cliente-cp" id="cliente-cp" placeholder="Código Postal" required >
                            </div>
                        </div>  
                        <div class="form-row">
                            <div class="form-group col-6 col-md-6">
                                <label for="cliente-colonia">Colonia</label>
                                <input type="text" class="form-control" name="cliente-colonia" id="cliente-colonia" placeholder="Colonia" required >
                            </div> 
                            <div class="form-group col-6 col-md-6">
                                <label for="cliente-municipio">Municipio</label>
                                <input type="text" class="form-control" name="cliente-municipio" id="cliente-municipio" placeholder="Municipio" required >
                            </div> 
                        </div>    
                        <div class="form-row">
                            <div class="form-group col-6 col-md-6">
                                <label for="cliente-estado">Estado</label>
                                <input type="text" class="form-control" name="cliente-estado" id="cliente-estado" placeholder="Estado" required >
                            </div> 
                            <div class="form-group col-6 col-md-6">
                                <label for="cliente-telefono">Teléfono</label>
                                <input type="text" class="form-control" name="cliente-telefono" id="cliente-telefono" placeholder="Teléfono" required >
                            </div> 
                        </div>                       
                    </div>  
                    <div class="form-group mx-auto" style="padding-right: 51px;">
                        <button type="submit" class="btn btn-primary mr-3">Guardar Cambios</button>
                        <input class="btn btn-light ml-3 " type="reset" value="Cancelar">
                    </div>                  
                </div> 
                <hr>                  
            </form>                       
        </div>
        <div class="col-md-12">
            
                
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>