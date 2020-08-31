<?php $__env->startSection('panel'); ?>
<h5>Mis Datos</h5> 
<hr>
<form role="form" action="<?php echo e(route('panelUsuario-editInfo')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <div class="row noval">
        <div class="col-12 col-md-6 col-sm-6" style="font-size:smaller">
            <div class="form-group">
                <label for="cliente-nombreCompleto">Nombre Completo</label>
                <input type="text" class="form-control" name="cliente-nombreCompleto" id="cliente-nombreCompleto" placeholder="Nombre Completo" value="<?php echo e($datosUser['nombreCom']); ?>">
            </div> 
            <div class="form-group">
                <label for="cliente-aPaterno">Apellido Paterno</label>
                <input type="text" class="form-control" name="cliente-aPaterno" id="cliente-aPaterno" placeholder="Apellido Paterno" value="<?php echo e($datosUser['aPaterno']); ?>">
            </div>
            <div class="form-group">
                <label for="cliente-aMaterno">Apellido Materno</label>
                <input type="text" class="form-control" name="cliente-aMaterno" id="cliente-aMaterno" placeholder="Apellido Materno" value="<?php echo e($datosUser['aMaterno']); ?>">
            </div>
            <div class="form-row">
                <div class="form-group col-6 col-md-6">
                    <label for="cliente-colonia">Colonia</label>
                    <input type="text" class="form-control" name="cliente-colonia" id="cliente-colonia" placeholder="Colonia" value="<?php echo e($datosUser['colonia']); ?>">
                </div> 
                <div class="form-group col-6 col-md-6">
                    <label for="cliente-municipio">Municipio</label>
                    <input type="text" class="form-control" name="cliente-municipio" id="cliente-municipio" placeholder="Municipio" value="<?php echo e($datosUser['municipio']); ?>">
                </div> 
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6" style="font-size:smaller">
            <div class="form-group">
                <label for="cliente-calle">Calle</label>
                <input type="text" class="form-control" name="cliente-calle" id="cliente-calle" placeholder="Calle" value="<?php echo e($datosUser['calle']); ?>">
            </div>
            <div class="form-group">
                <label for="cliente-entreCalle">Entre Calle</label>
                <input type="text" class="form-control" name="cliente-entreCalle" id="cliente-entreCalle" placeholder="Entre Calle" value="<?php echo e($datosUser['entreCalle']); ?>">
            </div>
            <div class="form-row">
                <div class="form-group col-4 col-md-4">
                    <label for="cliente-nExt">Número Exterior</label>
                    <input type="number" class="form-control" name="cliente-nExt" id="cliente-nExt" placeholder="Número Exterior" value="<?php echo e($datosUser['numExt']); ?>">
                </div> 
                <div class="form-group col-4 col-md-4">
                    <label for="cliente-nInt">Número Interior</label>
                    <input type="number" class="form-control" name="cliente-nInt" id="cliente-nInt" placeholder="Número Interior" value="<?php echo e($datosUser['numInt']); ?>">
                </div> 
                <div class="form-group col-4 col-md-4">
                    <label for="cliente-cp">Código Postal</label>
                    <input type="number" class="form-control" name="cliente-cp" id="cliente-cp" placeholder="Código Postal" value="<?php echo e($datosUser['cp']); ?>">
                </div>
            </div>  
            <div class="form-row">
                <div class="form-group col-6 col-md-6">
                    <label for="cliente-estado">Estado</label>
                    <input type="text" class="form-control" name="cliente-estado" id="cliente-estado" placeholder="Estado" value="<?php echo e($datosUser['estado']); ?>">
                </div> 
                <div class="form-group col-6 col-md-6">
                    <label for="cliente-telefono">Teléfono</label>
                    <input type="text" class="form-control" name="cliente-telefono" id="cliente-telefono" placeholder="Teléfono" value="<?php echo e($datosUser['telefono']); ?>">
                </div> 
            </div> 
            <div class="form-row">
                <div class="form-group col-12 col-md-12">
                    <label for="cliente-infoCorreo">Deseo recibir información por correo</label>
                    <?php if($datosUser['infoCorreo'] == 1): ?>
                        <input type="checkbox" name="cliente-infoCorreo" id="cliente-infoCorreo" checked>
                    <?php else: ?>
                        <input type="checkbox" name="cliente-infoCorreo" id="cliente-infoCorreo">
                    <?php endif; ?>
                </div>
            </div>                      
        </div>  
        <div class="form-group mx-auto" style="padding-right: 51px;">
            <button type="submit" class="btn btn-primary mr-3">Guardar Cambios</button>
            <a class="btn btn-light ml-3 " href="<?php echo e(route('panelUsuario')); ?>">Cancelar</a>
        </div>                  
    </div> 
    <hr>                  
</form> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cliente.basePanel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>