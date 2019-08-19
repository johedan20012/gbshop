@extends('layouts.base')

@section('titulo')
Administración gbshop
@endsection

@section('css')
<link rel="stylesheet" href=" {{ asset('css/auth/admin.css')}}" type="text/css">
@endsection

@section('contenido')
<?php
    if(!isset($numPag)){
        $numPag = 5;
    }elseif($numPag != 1 && $numPag != 2 && $numPag != 3 && $numPag != 4){
        $numPag = 5;
    }
    
?>

<div class="d-flex justify-content-center">
    <div class="row col-md-11">
        <div class="col-md-12 col-sm-12 col-12">
        <br>
        @if(Session::has('Mensaje') || Session::has('Error') || Session::has('Warning'))
            <div class="toast" id="myToast" data-autohide="false">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fa fa-grav"></i>Mensaje de GBShop</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    @if(Session::has('Mensaje'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('Mensaje') }}
                        </div>
                    @elseif(Session::has('Error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('Error') }}
                        </div>
                    @elseif(Session::has('Warning'))
                    <div class="alert alert-warning" role="alert">
                            {{ Session::get('Warning') }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="font-size:medium">
            @if( $numPag == 1 || $numPag == 5 )
                <a class="nav-item nav-link active" id="nav-productos-tab" data-toggle="tab" href="#nav-productos" role="tab" aria-controls="nav-productos" aria-selected="true">Productos</a>
            @else
                <a class="nav-item nav-link" id="nav-productos-tab" data-toggle="tab" href="#nav-productos" role="tab" aria-controls="nav-productos" aria-selected="false">Productos</a>
            @endif
            @if($numPag == 2)
                <a class="nav-item nav-link active" id="nav-marcas-tab" data-toggle="tab" href="#nav-marcas" role="tab" aria-controls="nav-marcas" aria-selected="true">Marcas</a>
            @else
                <a class="nav-item nav-link" id="nav-marcas-tab" data-toggle="tab" href="#nav-marcas" role="tab" aria-controls="nav-marcas" aria-selected="false">Marcas</a>
            @endif
            @if($numPag == 3)
                <a class="nav-item nav-link active" id="nav-categorias-tab" data-toggle="tab" href="#nav-categorias" role="tab" aria-controls="nav-categorias" aria-selected="true">Categorias</a>
            @else
                <a class="nav-item nav-link" id="nav-categorias-tab" data-toggle="tab" href="#nav-categorias" role="tab" aria-controls="nav-categorias" aria-selected="false">Categorias</a>
            @endif
            @if($numPag == 4)
                <a class="nav-item nav-link active" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="true">Admin</a>
            @else
                <a class="nav-item nav-link" id="nav-admin-tab" data-toggle="tab" href="#nav-admin" role="tab" aria-controls="nav-admin" aria-selected="false">Admin</a>
            @endif
            
            <a class="nav-item nav-link ml-auto" role = "tab" aria-controls="nav-admin" aria-selected="false" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
        @if( $numPag == 1 || $numPag == 5 )
        <div class="tab-pane fade show active" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
        @else
        <div class="tab-pane fade" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
        @endif
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
                                    <option value="">Seleccione una opción...</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->idmarcas}}">{{$marca->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>    
                            <div class="form-group">
                                <label for="producto-categoria">Categoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-categoria" id="producto-categoria" required>
                                    <option value="">Seleccione una opción...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->idcategorias}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="producto-subcategoria">SubCategoría</label>
                                <select class="form-control custom-select mr-sm-2" name="producto-subcategoria" id="producto-subcategoria">
                                    <option value="">Seleccione una opción...</option>
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
        @if( $numPag == 2)
        <div class="tab-pane fade show active" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
        @else
        <div class="tab-pane fade" id="nav-marcas" role="tabpanel" aria-labelledby="nav-marcas-tab ">
        @endif
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
                        @include('widgets.tablaMarcas')
                    </div>
                    
                </div>
                </div>
            </div>  
        </div>
        @if( $numPag == 3)
        <div class="tab-pane fade show active" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
        @else
        <div class="tab-pane fade" id="nav-categorias" role="tabpanel" aria-labelledby="nav-categorias-tab">
        @endif
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
                    <form class="form-inline">                        
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
                    </table>
                </div>
                </div>
            </div>  
        </div>
        @if( $numPag == 4)
        <div class="tab-pane fade show active" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
        @else
        <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
        @endif
            Panel de Administración
        </div>

        </div>
        
        </div>    
    </div>
</div>

@endsection

@section('scripts')
    <input type="hidden" value="{{ route('subCat') }}" id="rutaSubCategorias">
    <input type="hidden" value="{{ route('admin') }}" id="rutaMarcas">
    <script src="{{ asset('js/auth/admin.js') }}"></script>
@endsection