$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        var page = myurl.split('p=')[1];
        var cadena=$("#pedido-actual").val();

        buscarPedidos(cadena,page);
    });

    //Evento ajax de buscar pedido
    $(document).on('search', '#pedido-busca',function(event){ 
        var buscar = $('#pedido-busca').val();
        
        buscarPedidos(buscar,1);
    }); 

    $(document).on('submit', '#buscarPedido',function(event){
        event.preventDefault();
    });

    //Modal de editar y/o eliminar marcas
    $(document).on('show.bs.modal','#modalPedidos',function(event){
        var button = $(event.relatedTarget); // Obtiene el boton que activo al modal
        var clave = button.data('clave'); // Obtiene los datos de los atributos data-*
        var tipo = button.data('type');
        var modal = $(this);
        var btn1 = modal.find("#modal-boton1");
        var btn2 = modal.find("#modal-boton2");

        modal.find("#modal-tipo").val(tipo);
        modal.find("#modal-clave").val(clave);
        if(tipo == 1){
            var estatus = button.data('estatus');

            modal.find('#modalPedidosLabel').html('Modificar estatus');
            modal.find(".modal-body").html('<div class="row"><div class="col-md-12"><div class="form-group"><label for="pedido-estatus">Nuevo estatus del pedido*:</label><br><select name="pedido-estatus" id="pedido-estatus"><option value="">Seleccione una opcion...</option></select></div></div></div><div class="row"><div class="col-md-12"> <div class="form-group"><label for="pedido-comentarios">Comentarios*: (Explicación breve del porque se cambio el estatus)</label><br><textarea name="pedido-comentarios" id="pedido-comentarios" rows="3" cols="40" ></textarea></div></div></div>');
            
            let opciones = "";
            if(estatus == 1){   
                opciones = "<option value='0'>Cancelado</option><option value='2'>Pagado</option>"
            }else if(estatus == 2){
                opciones = "<option value='0'>Cancelado</option><option value='3'>En proceso de envio</option>"
            }else if(estatus == 3){
                opciones = "<option value='0'>Cancelado</option><option value='4'>Enviado</option>"
            }
            modal.find("#pedido-estatus").html(modal.find("#pedido-estatus").html()+opciones);
            
            modal.find("#pedido-estatus").change(function(){
                if($(this).val() == ""){
                    btn2.prop( "disabled", true );
                }else{
                    if($("#pedido-comentarios").val() != ""){
                        btn2.prop( "disabled", false );
                    }else{
                        btn2.prop( "disabled", true );
                    }
                }
            });

            modal.find("#pedido-comentarios").keyup(function(){
                if($(this).val() == ""){
                    btn2.prop( "disabled", true );
                }else{
                    if($("#pedido-estatus").val() != ""){
                        btn2.prop( "disabled", false );
                    }else{
                        btn2.prop( "disabled", true );
                    }
                }
            });

            btn1.html("Cancelar");
            btn2.html("Guardar");
            btn2.prop( "disabled", true );
        }else{
            modal.find("#modalPedidosLabel").html('Reenvio de correo');
            modal.find(".modal-body").html("Ingresa el correo del cliente donde se enviaran los detalles del pedido. <input id='modal-email' type='email' size='50' maxlength='50'><br> <input type='checkbox' id='modal-emailG'><label for='modal-emailG'>Usar correo registrado del usuario </label> ");
            modal.find("#modal-email").on("change",function(){
                if($("#modal-email").val() != ""){
                    $("#modal-boton2").prop("disabled",false);
                }else{
                    $("#modal-boton2").prop("disabled",true);
                }
            });
            modal.find("#modal-emailG").on("change",function(){
                if($("#modal-emailG").prop("checked") == true){
                    $("#modal-email").prop("disabled", true);
                    $("#modal-boton2").prop("disabled",false);
                }else{
                    $("#modal-email").prop("disabled", false);
                    if($("#modal-email").val() == ""){
                        $("#modal-boton2").prop("disabled",true);
                    }
                }
            })
            btn1.html("Cerrar");
            btn2.html("Enviar");
            btn2.prop( "disabled", true );
        }
    });
});

function procesarModal(modal){
    let tipo = modal.find("#modal-tipo").val();
    let clave = modal.find('#modal-clave').val();

    if(tipo == 1){
        let estatus = $("#pedido-estatus").val();
        let comentarios = $("#pedido-comentarios").val();

        actualizarEstatus(estatus,comentarios,clave);

        modal.moda("hide");
    }else{
        let correo = modal.find("#modal-email").val();
        let correoG = (modal.find("#modal-emailG").prop("checked") ) ? "true": "false";

        reenviarCorreo(correo,correoG,clave);

        modal.modal("hide");
    }
}

function actualizarEstatus(estatus,comentarios,clave){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaEditarEstatus').val(),
        data:{estatus:estatus,comentarios:comentarios,clavePedido:clave}
    }).done(function(data){
        mensaje = (data["Error"] == null)? data["Exito"] : data["Error"];
        if(data["Exito"] != null){location.reload();}
        alert(mensaje);
    });
}

function reenviarCorreo(correo,correoG,clave){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaReenviarCorreo').val(),
        data:{correo:correo,correoG:correoG,clavePedido:clave}
    }).done(function(data){
        mensaje = (data["Error"] == null)? data["Exito"] : data["Error"];
        alert(mensaje);
    });
}

function buscarPedidos(cadena,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaPedidos').val(),
        data:{cadena:cadena,p:page}
    }).done(function(data){
        //console.log(data);
        $("#del-pedido-form").empty().html(data.tabla);   

        $('#pedido-busca').focus();
        var datos =  $('#pedido-busca').val();
        $('#pedido-busca').val("").val(datos);

        var busqueda = $('#pedido-actual').val();
        if(busqueda != ""){ //Esto implica una busqueda 
            var nombres = $(".pedido-clave");
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