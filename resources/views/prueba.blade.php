@extends('layouts.base')

@section('contenido')
<div class="tab-pane fade show active" id="nav-productos" role="tabpanel" aria-labelledby="nav-productos-tab">
                <form role="form" action="{{route('borrar')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="col-12 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="foto">Selecciona Imágen...</label>
                                <input type="file" class="form-control" multiple name="foto[]" id="foto" required>
                            </div> 
                            <button type="submit" class="btn btn-danger">Agregar a la Página</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection