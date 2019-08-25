$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        var page = myurl.split('p=')[1];
        var cadena=$("#categoria-actual").val();

        buscarCategorias(cadena,page);
    });

    //Evento ajax de buscar categoria
    $(document).on('search', '#categoria-busca',function(event){ 
        var buscar = $('#categoria-busca').val();

        buscarCategorias(buscar,1);
    });

    $(document).on('submit', '#buscarCategoria',function(event){
        event.preventDefault();
    });

    //Modal de editar y/o eliminar marcas
    $(document).on('show.bs.modal','#modalCategorias',function(event){
        var button = $(event.relatedTarget); // Obtiene el boton que activo al modal
        var id = button.data('id'); // Obtiene los datos de los atributos data-*
        var nombre = button.data('nombre');
        console.log(nombre);
        var ruta = (button.data('type') == 2) ?  $('#rutaDelCategoria').val() : $('#rutaEditCategoria').val();
        var modal = $(this);

        modal.find('#categoria-id').val(id);
        modal.find('#form-modal-categoria').attr('action',ruta);

        if(button.data('type') == 2){
            modal.find('#modalCategoriasLabel').html('Eliminar categoria');
            modal.find('#div-categoria-nombre').html('¿Eliminar la categoria "'+nombre+'"?');
        }else{
            modal.find('#modalCategoriasLabel').html('Modificar categoria');
            modal.find('#div-categoria-nombre').html('<label for="message-text" class="col-form-label">Nombre:</label> <input type="text" class="form-control" name="categoria-nombre" id="categoria-nombre" value="'+nombre+'">');
        }
    });
});

function buscarCategorias(cadena,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaCategorias').val(),
        data:{cadena:cadena,p:page}
    }).done(function(data){
        $("#del-categoria-form").empty().html(data.tabla);   

        $('#categoria-busca').focus();
        var datos =  $('#categoria-busca').val();
        $('#categoria-busca').val("").val(datos);

        var busqueda = $('#categoria-actual').val();
        if(busqueda != ""){ //Esto implica una busqueda 
            var nombres = $(".nombre-categoria");
            for(let a=0; a<nombres.length; a++){
                var cadena = nombres.eq(a).html(),cadenaLower = cadena.toLowerCase();

                busqueda = busqueda.toLowerCase();

                var indices = [], i = -1;

                while((i= cadenaLower.indexOf(busqueda, i+1)) != -1){
                    indices.push(i);
                    i += (busqueda.length-1);
                }

                var nuevaCadena ="";
                var indice = 0;

                for(i = 0; i<indices.length; i++){
                    //console.log(indice + " " +indices[i]);
                    nuevaCadena += cadena.substring(indice,indices[i]);
                    nuevaCadena += "<strong class='text-danger'>";
                    nuevaCadena += cadena.substring(indices[i],indices[i]+busqueda.length);
                    nuevaCadena += "</strong>";

                    indice = indices[i]+busqueda.length;
                }
                nuevaCadena += cadena.substring(indice);

                nombres.eq(a).html(nuevaCadena);
            }
        }
    });
}