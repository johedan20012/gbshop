@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="add-categoria">
            <h4 aling="center" class="titulo">
            <i class="fa fa-plus"></i>
            Agregar Categoria / SubCategoria
            </h4>
            <form role="form" action="{{route('storeCategoria')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="categoria-nombre">Nombre:</label>
                    <input type="text" class="form-control" name="categoria-nombre" id="categoria-nombre" required>
                </div>
                <div class="form-group">
                    <label for="categoria-padre">Pertenece a la categoria:</label>
                    <select class="form-control" name="categoria-padre" id="categoria-padre">
                    <option value="">Seleccione una opción</option>
                        @foreach($categorias as $categoria)
                            <option value="{{$categoria->idcategorias}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-danger" value="Agregar a la Página">                                                      
            </form>
        </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
        <br>
        <div id="del-categoria">
            <div id="del-categoria-form">
                @include('widgets.admin.tablaCategorias')
            </div>
        </div>
    </div>  
</div>
@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
        <input type="hidden" value="{{ route('tablaCategorias') }}" id="rutaCategorias">
        <input type="hidden" value="{{ route('editCategoria') }}" id="rutaEditCategoria">
        <input type="hidden" value="{{ route('delCategoria') }}" id="rutaDelCategoria">
        <script src="{{ asset('js/admin/tabCategorias.js') }}"></script>
@endsection