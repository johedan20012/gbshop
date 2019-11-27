<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $categorias1->links('widgets.pagination') !!}
    </div>

    <form class="form-inline mr-3" id="buscarCategoria" action="">          
        @if(isset($actual))  
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar" value="{{ $actual }}"> 
        @else
            <input type="search" class="form-group" name="categoria-busca" id="categoria-busca" placeholder="Buscar"> 
        @endif            
                               
        <i class="fa fa-search"></i>
    </form>

    @if(isset($actual))  
        <input type="hidden" id="categoria-actual" value="{{ $actual }}">  
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
        @if($categoria->padre != null)
            <td class="text-primary">{{$categoria->padre->nombre}}</td>
        @else
            <td>Ninguno</td>
        @endif
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#modalCategorias" data-id="{{$categoria->idcategorias}}" data-nombre="{{$categoria->nombre}}"><i class="fa fa-edit" style="color:blue"> </i> Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#modalCategorias" data-id="{{$categoria->idcategorias}}" data-nombre="{{$categoria->nombre}}"><i class="fa fa-times" style="color: red"> </i> Eliminar</button>
            </div>
            </div>
        </td>
        </tr>
        <tr>
    @endforeach
    
    </tr>
</tbody>
</table>

<!--Modales-->

<div class="modal fade" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="modalCategoriasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCategoriasLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-categoria" action="" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" class="form-control" name="categoria-id" id="categoria-id">
          <div class="form-group" id="div-categoria-nombre">
            <label for="message-text" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" name="categoria-nombre" id="categoria-nombre">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-categoria').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>