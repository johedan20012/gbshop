<div class="row d-flex justify-content-between">
    <div class="row ml-3">
        {!! $admins->links('widgets.pagination') !!}
    </div>
</div>

<table class="table table-hover">
<thead>
    <tr>
    <th scope="col">Nombre de usuario</th>
    <th scope="col" class="centro">Acciones</th>
    </tr>
</thead>
<tbody>
    <tr>
    @if(count($admins) == 0)
        No se encontraron admins con los datos solicitados.
    @endif

    @foreach($admins as $admin)
        <td class="nombre-admin">{{$admin->username}}</td>
        <td>
            <div class="btn-group d-flex justify-content-center">
            <button type="button" class="btn btn-danger col-md-12 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Acciones
            </button>
            <div class="dropdown-menu">
                <button class="dropdown-item" data-toggle="modal" data-type="1" data-target="#modalAdmins" data-id="{{$admin->idadmins}}" data-nombre="{{$admin->username}}"><i class="fa fa-edit" style="color:blue"> </i> Cambiar contraseña</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-type="2" data-target="#modalAdmins" data-id="{{$admin->idadmins}}" data-nombre="{{$admin->username}}"><i class="fa fa-times" style="color: red"> </i> Eliminar</button>
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

<div class="modal fade" id="modalAdmins" tabindex="-1" role="dialog" aria-labelledby="modalAdminsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAdminsLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal-admin" action="" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" class="form-control" name="admin-id" id="admin-id">
            <div class="form-group" id="div-admin-pass">
                <label class="rojo-red" for="admin-pass">Contraseña:</label>
                <input type="password" class="form-control" name="admin-pass" id="admin-pass" placeholder="7 a 15 caracteres" autocomplete="off"  required>
            </div>
            <div class="form-group" id="div-admin-passConf">
                <label class="rojo-red" for="admin-pass-confirmation">Confirmar contraseña:</label>
                <input type="password" class="form-control" name="admin-pass_confirmation" id="admin-pass-confirmation" placeholder="7 a 15 caracteres" autocomplete="off" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="$('#form-modal-admin').submit()"class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>