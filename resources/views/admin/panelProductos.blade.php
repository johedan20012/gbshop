@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
            <br>
            <div id="add-producto">
                <h4 aling="center" class="titulo">
                    <i class="fa fa-plus"></i>
                    Agregar Productos
                </h4>
                <form role="form" action="{{route('regProducto')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="producto-nombre">Nombre</label>
                        <input type="text" class="form-control" name="producto-nombre" id="producto-nombre" placeholder="Nombre" required value="{{old('producto-nombre')}}">
                    </div>    
                    <div class="form-group">
                        <label for="producto-descripcion">Descripción</label>
                        <textarea class="form-control" name="producto-descripcion" id="producto-descripcion" placeholder="Descripción" rows="3">{{old('producto-descripcion')}}</textarea>
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
                        <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria">
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
                        <input type="file" class="form-control" multiple name="producto-foto[]" id="producto-foto" required>
                    </div> 
                    <button type="submit" class="btn btn-danger">Agregar a la Página</button>                                                      
                </form>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <br>
            <div id="del-producto-form">
                Poner para Borrar segunda columna
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
        <input type="hidden" value="{{ route('subCat') }}" id="rutaSubCategorias">
        <script src="{{ asset('js/admin/tabProductos.js') }}"></script>
@endsection