$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        var page = myurl.split('p=')[1];

        buscarAdmins(page);
    });

    //Modal de editar y/o eliminar marcas
    $(document).on('show.bs.modal','#modalAdmins',function(event){
        var button = $(event.relatedTarget); // Obtiene el boton que activo al modal
        var id = button.data('id'); // Obtiene los datos de los atributos data-*
        var nombre = button.data('nombre');
        var ruta = (button.data('type') == 2) ?  $('#rutaDelAdmin').val() : $('#rutaEditAdmin').val();
        var modal = $(this);

        modal.find('#admin-id').val(id);
        modal.find('#form-modal-admin').attr('action',ruta);

        if(button.data('type') == 2){
            modal.find('#modalAdminsLabel').html('Eliminar administrador');
            modal.find('#div-admin-pass').html('¿Eliminar el administrador "'+nombre+'"?');
            modal.find('#div-admin-passConf').html("");
        }else{
            modal.find('#modalAdminsLabel').html('Cambiar contraseña al administrador '+nombre);
            modal.find('#div-admin-pass').html('<label class="rojo-red" for="admin-pass">Contraseña nueva:</label> <input type="password" class="form-control" name="admin-pass" id="admin-pass" placeholder="7 a 15 caracteres" autocomplete="off"  required>');
            modal.find('#div-admin-passConf').html('<label class="rojo-red" for="admin-pass-confirmation">Confirmar contraseña:</label><input type="password" class="form-control" name="admin-pass_confirmation" id="admin-pass-confirmation" placeholder="7 a 15 caracteres" autocomplete="off" required>');
        }
    });
});

function buscarAdmins(page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaAdmins').val(),
        data:{p:page}
    }).done(function(data){
        $("#del-admin-form").empty().html(data.tabla);   
    });
}