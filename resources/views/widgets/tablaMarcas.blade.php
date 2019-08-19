
<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $marcas1->links('widgets.pagination') !!}
    </div>

    <form class="form-inline mr-3" id="buscarMarca" action="">          
        @if(isset($actual))  
            <input type="search" class="form-group" name="marca-busca" id="marca-busca" placeholder="Buscar" value="{{ $actual }}"> 
        @else
            <input type="search" class="form-group" name="marca-busca" id="marca-busca" placeholder="Buscar"> 
        @endif            
                               
        <i class="fa fa-search"></i>
    </form>

    @if(isset($actual))  
        <input type="hidden" id="marca-actual" value="{{ $actual }}">  
    @else
        <input type="hidden" id="marca-actual" value=""> 
    @endif
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    @if(count($marcas1) == 0)
        No se encontraron marcas con los datos solicitados.
    @endif

    <?php $contador = 1?>
    @foreach($marcas1 as $marca)
        <td class="nombre-marca">{{$marca->nombre}}</td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-8 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-target="#modalEditarMarcas" data-whatever="{{$marca->idmarcas}}"><i class="fa fa-edit" style="color:blue"> </i>_Modificar</button>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fa fa-times" style="color: red"> </i>_Eliminar</a>
            </div>
            </div>
        </td>
        </tr>
        <tr>

        <?php $contador += 1?>
    @endforeach
    
    </tr>
</tbody>
</table>

<!--Modales-->

<div class="modal fade" id="modalEditarMarcas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
