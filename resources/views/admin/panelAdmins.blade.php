@extends('layouts.admin.base')

@section('nav-tab')
<div class="tab-pane fade show active" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">
    Panel de administradores
</div>
@endsection

@section('scripts')
    <?php //Esto incluye la section 'scripts' definida por mi padre, en caso de existir , sin esto , mi seccion sobreescribiria la definida por mi padre?>
    @parent
        
@endsection