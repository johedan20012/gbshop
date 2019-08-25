$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        var page = myurl.split('p=')[1];
        var cadena=$("#marca-actual").val();

        buscarMarcas(cadena,page);
    });
    /*
    var timeout = null;
    //Buscador de marcas
    $(document).on('keyup', '#marca-busca',function(event){ 
        clearTimeout(timeout);

        timeout = setTimeout(function () {
            var buscar = $('#marca-busca').val();
            buscarMarcas(buscar,1);
        }, 500);
    }); */

    //Evento ajax de buscar marca
    $(document).on('search', '#marca-busca',function(event){ 
        var buscar = $('#marca-busca').val();
        
        buscarMarcas(buscar,1);
    }); 

    $(document).on('submit', '#buscarMarca',function(event){
        event.preventDefault();
    });

    //Modal de editar y/o eliminar marcas
    $(document).on('show.bs.modal','#modalMarcas',function(event){
        var button = $(event.relatedTarget); // Obtiene el boton que activo al modal
        var id = button.data('id'); // Obtiene los datos de los atributos data-*
        var nombre = button.data('nombre');
        var ruta = (button.data('type') == 2) ?  $('#rutaDelMarca').val() : $('#rutaEditMarca').val();
        var modal = $(this);

        modal.find('#marca-id').val(id);
        modal.find('#form-modal-marca').attr('action',ruta);

        if(button.data('type') == 2){
            modal.find('#modalMarcasLabel').html('Eliminar marca');
            modal.find('#div-marca-nombre').html('¿Eliminar la marca "'+nombre+'"?');
        }else{
            modal.find('#modalMarcasLabel').html('Modificar marca');
            modal.find('#div-marca-nombre').html('<label for="message-text" class="col-form-label">Nombre:</label> <input type="text" class="form-control" name="marca-nombre" id="marca-nombre" value="'+nombre+'">');
        }
    });
});

function buscarMarcas(cadena,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaMarcas').val(),
        data:{cadena:cadena,p:page}
    }).done(function(data){
        //console.log(data);
        $("#del-marca-form").empty().html(data.tabla);   

        $('#marca-busca').focus();
        var datos =  $('#marca-busca').val();
        $('#marca-busca').val("").val(datos);

        var busqueda = $('#marca-actual').val();
        if(busqueda != ""){ //Esto implica una busqueda 
            var nombres = $(".nombre-marca");
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