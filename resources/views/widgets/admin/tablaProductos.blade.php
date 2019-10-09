<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $productos->links('widgets.pagination') !!}
    </div>

    <form class="form-inline mr-3" id="buscarProducto" action="">          
        @if(isset($actual))  
            <input type="search" class="form-group" name="producto-busca" id="producto-busca" placeholder="Buscar" value="{{ $actual }}"> 
        @else
            <input type="search" class="form-group" name="producto-busca" id="producto-busca" placeholder="Buscar"> 
        @endif            
                               
        <i class="fa fa-search"></i>
    </form>

    @if(isset($actual))  
        <input type="hidden" id="producto-actual" value="{{ $actual }}">  
    @else
        <input type="hidden" id="producto-actual" value=""> 
    @endif
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre</th>
    <th scope="col">Descripcion</th>
    <th scope="col">Marca</th>
    <th scope="col">Categoria</th>
    <th scope="col">Precio</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    @if(count($productos) == 0)
        No se encontraron productos con los datos solicitados.
    @endif

    @foreach($productos as $producto)
        <td class="nombre-producto" id="{{$producto->idproductos}}nombre">{{$producto->nombre}}</td>
        <td class="descripcion-producto" ><textarea rows="4" cols="50" disabled id="{{$producto->idproductos}}desc">{{$producto->descripcion}}</textarea></td>
        <td class="marca-producto" >{{$producto->marca->nombre}}</td>
        <td class="categoria-producto" >{{$producto->categoria->nombre}}</td>
        <td class="precio-producto" >${{$producto->precio}}</td>
        <input type="hidden" id="{{$producto->idproductos}}precio" value="{{$producto->precioSF}}">
        @if($producto->categoria->padre != null)
          <input type="hidden" id="{{$producto->idproductos}}categoriaPadre" value="{{$producto->categoria->padre->idcategorias}}">
        @endif
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-type="1" data-marca="{{$producto->marca->idmarcas}}" data-categoria="{{$producto->categoria->idcategorias}}" data-id="{{$producto->idproductos}}"  data-target="#modalProductos" ><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-type="2" data-id="{{$producto->idproductos}}"  data-target="#modalProductos" ><i class="fa fa-times" style="color: red"> </i>_Eliminar</button>
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

<div class="modal fade" id="modalProductos" tabindex="-1" role="dialog" aria-labelledby="modalProductosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductosLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-producto" action="" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div id="editarProducto">
            <div class="row">
                <input type="hidden" name="producto-id" id="producto-id">
                <div class="col-12 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="producto-nombre">Nombre</label>
                        <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required value="{{old('producto-nombre')}}">
                    </div>    
                    <div class="form-group">
                        <label for="producto-descripcion">Descripción</label>
                        <textarea class="form-control" style="height:125px;" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3">{{old('producto-descripcion')}}</textarea>
                    </div>  
                    <div class="form-group">
                        <label for="producto-marca">Marca</label>
                        <select class="form-control custom-select mr-sm-2" name="producto-marca" id="producto-marca" required>
                            <option value="">Seleccione una marca...</option>
                            @foreach($marcas as $marca)
                                <option value="{{$marca->idmarcas}}">{{$marca->nombre}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                <div class="col-12 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="producto-categoria">Categoría</label>
                        <select class="form-control custom-select mr-sm-2" name="producto-categoria" id="producto-categoria" required>
                            <option value="">Seleccione una categoria...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->idcategorias}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="producto-subcategoria">SubCategoría</label>
                        <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria2">
                            <option value="">Sin subcategoria</option>
                        </select>
                    </div> 
                    <label for="producto-precio">Precio</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control" name="producto-precio" id="producto-precio" placeholder="Precio" required step=".01">
                    </div>  
                    <div class="form-group">
                        <label for="producto-foto">Selecciona Imágen...</label>
                        <input type="file" class="form-control" multiple name="producto-foto[]" id="producto-foto" required style="padding: 0;">
                    </div> 
                </div>
            </div>
            <a class="" data-toggle="collapse" href="#modal-form-fotos" role="button" aria-expanded="true" aria-controls="modal-form-fotos">
              Modificar fotos
            </a> 
            <div id="modal-form-fotos" class="collapse" aria-labelledby="headingOne" data-parent="#editarProducto" style="position: relative;">
            </div>
          </div>
          <div id="borrarProducto">
          
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-producto').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>