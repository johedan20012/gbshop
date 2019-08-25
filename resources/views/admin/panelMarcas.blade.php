@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="add-marca">
            <h4 aling="center" class="titulo">
            <i class="fa fa-plus"></i>
            Agregar Marca
            </h4>
            <form role="form" action="{{route('storeMarca')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="marca-nombre">Nombre</label>
                <input type="text" class="form-control" name="marca-nombre" id="marca-nombre" placeholder="Nombre" required>
            </div>
            <button type="submit" class="btn btn-danger">Agregar a la Página</button>                                                      
            </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="del-marca">
            <div id="del-marca-form">
                @include('widgets.admin.tablaMarcas')
            </div>
        </div>
        </div>
    </div>  
</div>
@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
        <input type="hidden" value="{{ route('tablaMarcas') }}" id="rutaMarcas">
        <input type="hidden" value="{{ route('editMarca') }}" id="rutaEditMarca">
        <input type="hidden" value="{{ route('delMarca') }}" id="rutaDelMarca">
        <script src="{{ asset('js/admin/tabMarcas.js') }}"></script>
@endsection