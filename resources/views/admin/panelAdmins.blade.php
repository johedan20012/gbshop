@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-admins" role="tabpanel" aria-labelledby="nav-admins-tab">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="add-admin">
            <h4 aling="center" class="titulo">
            <i class="fa fa-plus"></i>
            Agregar administrador
            </h4>
            <form role="form" action="{{ route('registroAdmin')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="admin-username">Nombre de usuario:</label>
                    <input type="text" class="form-control" name="admin-username" id="admin-username" required>
                </div>
                <div class="form-group">
                    <label class="rojo-red" for="admin-pass">Contraseña:</label>
                    <input type="password" class="form-control" name="admin-pass" id="admin-pass" placeholder="7 a 15 caracteres" autocomplete="off"  required>
                </div>
                <div class="form-group">
                    <label class="rojo-red" for="admin-pass-confirmation">Confirmar contraseña:</label>
                    <input type="password" class="form-control" name="admin-pass_confirmation" id="admin-pass-confirmation" placeholder="7 a 15 caracteres" autocomplete="off" required>
                </div>
                <input type="submit" class="btn btn-danger" value="Registrar administrador">                                                      
            </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="del-admin">
            <div id="del-admin-form">
                @include('widgets.admin.tablaAdmins')
            </div>
        </div>
    </div>  
</div>

@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
    <input type="hidden" value="{{ route('tablaAdmins') }}" id="rutaAdmins">
    <input type="hidden" value="{{ route('editAdmin') }}" id="rutaEditAdmin">
    <input type="hidden" value="{{ route('delAdmin') }}" id="rutaDelAdmin">
    <script src="{{ asset('js/admin/tabAdmins.js') }}"></script>    
@endsection