<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        <?php echo $categorias1->links('widgets.pagination'); ?>

    </div>

    <form class="form-inline mr-3" id="buscarCategoria" action="">          
        <?php if(isset($catActual)): ?>  
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar" value="<?php echo e($catActual); ?>"> 
        <?php else: ?>
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar"> 
        <?php endif; ?>            
                               
        <i class="fa fa-search"></i>
    </form>

    <?php if(isset($catActual)): ?>  
        <input type="hidden" id="categoria-actual" value="<?php echo e($catActual); ?>">  
    <?php else: ?>
        <input type="hidden" id="categoria-actual" value=""> 
    <?php endif; ?>
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre</th>
    <th scope="col">Categoria padre</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    <?php if(count($categorias1) == 0): ?>
        No se encontraron marcas con los datos solicitados.
    <?php endif; ?>

    <?php $__currentLoopData = $categorias1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <td class="nombre-categoria"><?php echo e($categoria->nombre); ?></td>
        <td><?php echo e($categoria->idcategorias); ?></td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-10 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarCategorias" data-id="<?php echo e($categoria->idcategorias); ?>" data-nombre="<?php echo e($categoria->nombre); ?>"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarCategorias" data-id="<?php echo e($categoria->idcategorias); ?>" data-nombre="<?php echo e($categoria->nombre); ?>"><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
            </div>
            </div>
        </td>
        </tr>
        <tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    </tr>
</tbody>
</table>




<!--<form class="form-inline">                        
    <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar">                        
    <a href="#"><i class="fa fa-search"></i></a>
</form>
</div>
<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Nombre</th>
    <th scope="col" class="centro">Sub Categoria</th>
    <TH scope="COL" class="centro">Acciones</TH>
    </tr>
</thead>
<tbody>
    <tr>
    <th scope="row">1</th>
    <td>Guitarras</td>
    <td>
        <div class="form-check">
        <input class="form-check-input position-static center" type="checkbox" id="blankCheckbox" value="option1" aria-label="subcategoria" checked disabled >
        </div>  
    </td>
    <td>
        <div class="btn-group d-flex">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="fa fa-times" style="color: red"> </i>_Eliminar</a>
        </div>
        </div>
    </td>
    </tr>
    <tr>
    <th scope="row">2</th>
    <td>Ukuleles</td>
    <td>
        <div class="form-check">
        <input class="form-check-input position-static center" type="checkbox" id="blankCheckbox2" value="option2" aria-label="subcategoria"  disabled >
        </div>   
    </td>
    <td>
        <div class="btn-group d-flex">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Acciones
        </button>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="#"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</a>
        <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="fa fa-times" style="color: red"> </i>_Eliminar</a>
        </div>
        </div> 
    </td>
    </tr>
</tbody>
</table> -->