var conektaSuccessResponseHandler,conektaErrorResponseHandler;
$(document).ready(function(){
    $(document).on('click', '#cliente-dirAlmacenada',function(event){
        if($("#cliente-dirAlmacenada").prop('checked')){ //Llenamos campos

        }else{ //Vaciamos campos
            $(".form-envio-cliente").val("");
        }
    });

    Conekta.setPublicKey('key_JaKbrsnAzjx1CaX9dso6qWA');

    conektaSuccessResponseHandler = function(token) {
        var form = $("#form-envio");
        //Inserta el token_id en la forma para que se envíe al servidor
        form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url: form.attr('action'),
            data: form.serialize(), 
        }).done(function(data){
            let modal = $("#modalMensaje");

            if(data[0] == "Exito"){
                modal.find("#imgOk").show();
                modal.find("#imgError").hide();
                modal.modal("show");
                modal.find("#modalMensajeLabel").html("Exito");
                modal.find("#modal-mensaje").html(data[1]);
                modal.find("#modal-boton2").html("Aceptar");
                modal.find("#modal-boton2").show();
                modal.find("#modal-boton1").hide();

                modal.on('hidden.bs.modal', function (e) {
                    window.location.href = './';
                });
            }else{
                modal.find("#imgOk").hide();
                modal.find("#imgError").show();
                modal.modal("show");
                modal.find("#modalMensajeLabel").html("Error");
                modal.find("#modal-mensaje").html(data[1]);
                modal.find("#modal-boton1").html("Aceptar");
                modal.find("#modal-boton2").hide();
            } 
        });
        //$form.get(0).submit(); ///Hace submit
    };
    conektaErrorResponseHandler = function(response) {
        let modal = $("#modalMensaje");
        modal.find("#imgOk").hide();
        modal.find("#imgError").show();
        modal.modal("show");
        modal.find("#modalMensajeLabel").html("Error");
        modal.find("#modal-mensaje").html(response.message_to_purchaser);
        modal.find("#modal-boton1").html("Aceptar");
        modal.find("#modal-boton2").hide();
    };
});

function procesarCompra(boton){
    boton.prop("disabled",true);
    boton.css({ 'background': 'grey', 'border': 'grey' });

    if(!$("#form-envio")[0].checkValidity()){ ///Los datos de envio no son validos
        $("#collapse1").removeClass("show");
        $("#collapse2").addClass("show");
        $("#collapse3").removeClass("show");
        
        let toast = $("#toast-envio");
        toast.show();
        toast.find("#mensaje").html("Verifica los datos de envio");
        toast.toast('show');
        toast.on('hidden.bs.toast',function(){
            toast.hide();
        });
        
        boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
        boton.prop("disabled",false);
        return;
    }
    
    var metodo = ($("#pm-conektaCash").prop("checked"))? 1 : ($("#pm-conektaCard").prop("checked"))? 2 : 0;
    
    switch(metodo){
        case 0:
            let modal = $("#modalMensaje");
            modal.find("#imgOk").hide();
            modal.find("#imgError").show();
            modal.modal("show");
            modal.find("#modalMensajeLabel").html("Error");
            modal.find("#modal-mensaje").html("Selecciona una forma de pago antes de realizar la compra");
            modal.find("#modal-boton1").html("Aceptar");
            modal.find("#modal-boton2").hide();
            break;
        case 1:
            ///Procesar pago de oxxo
            
            break;
        case 2:
            ///Procesar pago de tarjeta
            if(!$("#card-form")[0].checkValidity()){
                let toast = $("#toast-tarjeta");
                toast.show();
                toast.find("#mensaje").html("Verifica los datos de tu tarjeta");
                toast.toast('show');
                toast.on('hidden.bs.toast',function(){
                    toast.hide();
                });
            }

            crearToken();
            break;
    }
    boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
    boton.prop("disabled",false);
}

function crearToken(){
    var parametrosToken = {
        "card": {
            "number": $("#card-number").val(),
            "name": $("#card-name").val(),
            "exp_year": $("#card-yearExp").val(),
            "exp_month": $("#card-monthExp").val(),
            "cvc": $("#card-cvc").val()
        }
    };

    Conekta.Token.create(parametrosToken, conektaSuccessResponseHandler, conektaErrorResponseHandler);
}