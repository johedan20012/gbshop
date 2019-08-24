<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $categorias1->links('widgets.pagination') !!}
    </div>

    <form class="form-inline mr-3" id="buscarCategoria" action="">          
        @if(isset($catActual))  
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar" value="{{ $catActual }}"> 
        @else
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar"> 
        @endif            
                               
        <i class="fa fa-search"></i>
    </form>

    @if(isset($catActual))  
        <input type="hidden" id="categoria-actual" value="{{ $catActual }}">  
    @else
        <input type="hidden" id="categoria-actual" value=""> 
    @endif
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
    @if(count($categorias1) == 0)
        No se encontraron marcas con los datos solicitados.
    @endif

    @foreach($categorias1 as $categoria)
        <td class="nombre-categoria">{{$categoria->nombre}}</td>
        <td>{{$categoria->idcategorias}}</td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-10 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarCategorias" data-id="{{$categoria->idcategorias}}" data-nombre="{{$categoria->nombre}}"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarCategorias" data-id="{{$categoria->idcategorias}}" data-nombre="{{$categoria->nombre}}"><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
            </div>
            </div>
        </td>
        </tr>
        <tr>
    @endforeach
    
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