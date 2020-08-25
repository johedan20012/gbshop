var conektaSuccessResponseHandler,conektaErrorResponseHandler,boton;

$(document).ready(function(){
    $(document).on('click', '#cliente-dirAlmacenada',function(event){
        if($("#cliente-dirAlmacenada").prop('checked')){ //Llenamos campos
            traerDatosCliente();
            $("#cliente-dirAlmacenada").prop("disabled",true);
        }else{ //Vaciamos campos
            $(".form-envio-cliente").val("");
        }
    });

    $(document).on("change","#card-mesesIntereses",function(){
        $("#mesesDetalleEtiqueta").show();
        $("#mesesDetalleValor").show();
        let precio = $("#total-compra").val();
        let precio10 = $("#total-compra-10").val();
        let aumento10 = $("#aumento-compra-10").val();
        let precio15 = $("#total-compra-15").val();
        let aumento15 = $("#aumento-compra-15").val();
        switch($(this).val()){
            case "1": //?Tres meses sin intereses
                $("#producto-precio").html("$"+precio10);
                $("#mesesDetalleValor").html("$"+aumento10);
                break;
            case "2": //?Seis meses sin intereses
                $("#producto-precio").html("$"+precio10);
                $("#mesesDetalleValor").html("$"+aumento10);
                break;
            case "3": //?Nueve meses sin intereses
                $("#producto-precio").html("$"+precio15);
                $("#mesesDetalleValor").html("$"+aumento15);
                break;
            case "4": //?Doce meses sin intereses
                $("#producto-precio").html("$"+precio15);
                $("#mesesDetalleValor").html("$"+aumento15);    
                break;
            default: //?Cualquier otra opción
                $("#producto-precio").html("$"+precio);   
                $("#mesesDetalleEtiqueta").hide();
                $("#mesesDetalleValor").hide();
                break;
        }
    });

    paypal.Buttons({
        enableStandardCardFields: false,
        createOrder: function(data, actions) {
            // Set up the transaction
            totalCompra = $("#total-compra-sf").val();
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: "MXN",
                        value: totalCompra
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // Capture the funds from the transaction
            boton.prop("disabled",true);
            boton.css({ 'background': 'grey', 'border': 'grey' });

            return actions.order.capture().then(function(details) {
                // Show a success message to your buyer

                //alert('Transaction completed by ' + details.payer.name.given_name);
                var form = $("#form-envio");
                //Inserta el token_id en la forma para que se envíe al servidor
                form.append($('<input type="hidden" name="paypalTokenOrder" id="paypalTokenOrder">').val(data.orderID));
                form.append($('<input type="hidden" name="tipoDePago" id="tipoDePago">').val("Paypal"));

                mostrarModal('Pago de Paypal aceptado con éxito, puedes finalizar la compra con el botón "Comprar"',1);

                $("#collapseFour").removeClass("show");
                $("#accordionPago *").prop('disabled',true);

                boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
                boton.prop("disabled",false);
            });
        },
        onError: ( error ) => {
            //console.log(error);
            
            $("#pm-paypal").prop("checked",false);
            $("#collapseFour").removeClass("show");

            mostrarModal("No se pudo procesar tu pago de Paypal",0);

            boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
            boton.prop("disabled",false);
        }
    }).render('#paypal-button-container');

    Conekta.setPublicKey($("#llaveConekta").val());

    boton = $("#continuarCompra");

    conektaSuccessResponseHandler = function(token) {
        var form = $("#form-envio");
        //Inserta el token_id en la forma para que se envíe al servidor
        form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
        form.append($('<input type="hidden" name="tipoDePago" id="tipoDePago">').val("ConektaTarjeta"));
        
        mandarFormulario(); //Hace el submit
    };
    conektaErrorResponseHandler = function(response) {
        mostrarModal(response.message_to_purchaser,0);

        boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
        boton.prop("disabled",false);
    };
});

function mostrarModal(mensaje,status = 0){
    let modal = $("#modalMensaje");
    if(status == 1){ //Exito
        modal.find("#imgOk").show();
        modal.find("#imgError").hide();
        modal.find("#imgCargando").hide();
        modal.modal("show");
        modal.find("#modalMensajeLabel").html("Éxito");
        modal.find("#modal-mensaje").html(mensaje);
        modal.find("#modal-boton2").html("Aceptar");
        modal.find("#modal-boton2").show();
        modal.find("#modal-boton1").hide();
    }else if(status == 0){ //Error
        modal.find("#imgOk").hide();
        modal.find("#imgError").show();
        modal.find("#imgCargando").hide();
        modal.modal("show");
        modal.find("#modalMensajeLabel").html("Error");
        modal.find("#modal-mensaje").html(mensaje);
        modal.find("#modal-boton1").html("Aceptar");
        modal.find("#modal-boton2").hide();
    }else{
        modal.find("#imgOk").hide();
        modal.find("#imgError").hide();
        modal.find("#imgCargando").show();
        modal.modal("show");
        modal.find("#modalMensajeLabel").html("Procesando tu compra");
        modal.find("#modal-mensaje").html(mensaje);
        modal.find("#modal-boton1").hide();
        modal.find("#modal-boton2").hide();
    }
}

function traerDatosCliente(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $("#rutaDatosEnvio").val()
    }).done(function(data){
        $("#cliente-dirAlmacenada").prop("disabled",false);
        if(data != ""){
            let form = $("#form-envio");
            form.find("#cliente-nombreCompleto").val(data["nombreCom"]);
            form.find("#cliente-aPaterno").val(data["aPaterno"]);
            form.find("#cliente-aMaterno").val(data["aMaterno"]);
            form.find("#cliente-calle").val(data["calle"]);
            form.find("#cliente-entreCalle").val(data["entreCalle"]);
            form.find("#cliente-nExt").val(data["numExt"]);
            form.find("#cliente-nInt").val(data["numInt"]);
            form.find("#cliente-cp").val(data["cp"]);
            form.find("#cliente-calle").val(data["calle"]);
            form.find("#cliente-municipio").val(data["municipio"]);
            form.find("#cliente-colonia").val(data["colonia"]);
            form.find("#cliente-estado").val(data["estado"]);
            form.find("#cliente-telefono").val(data["telefono"]);
            form.find("#cliente-referencias").val(data["referencias"]);
        }
    });
}

function mandarFormulario(){
    mostrarModal("",2);
    var form = $("#form-envio");
    form.find("#cliente-mesesIntereses").val($("#card-mesesIntereses").val());
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
        if(data[0] == "Exito"){
            mostrarModal(data[1],1);
            let modal = $("#modalMensaje");
            modal.on('hidden.bs.modal', function (e) {
                window.location.href = './';
            });
        }else{
            mostrarModal(data[1],0);
        } 
        boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
        boton.prop("disabled",false);
    }).fail( function(data) {
        console.log(data);
        mostrarModal("Error interno, intente mas tarde, si realizó un pago de Paypal contactenos para registrarlo",0);

        boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
        boton.prop("disabled",false);
    });
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

function procesarCompra(){
    boton.prop("disabled",true);
    boton.css({ 'background': 'grey', 'border': 'grey' });

    if(!$("#form-envio")[0].checkValidity()){ ///Los datos de envio no son validos
        window.scrollTo(0,0);
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
    
    var metodo = ($("#pm-conektaCash").prop("checked"))? 1 : ($("#pm-conektaCard").prop("checked"))? 2 : ($("#pm-paypal").prop("checked"))? 3: 0;
    
    switch(metodo){
        case 0:
            mostrarModal("Selecciona una forma de pago antes de realizar la compra",0);
           
            boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
            boton.prop("disabled",false);
            break;
        case 1:
            ///Procesar pago de oxxo
            let form = $("#form-envio");

            form.append($('<input type="hidden" name="tipoDePago" id="tipoDePago">').val("ConektaOXXO"));
            mandarFormulario();
            break;
        case 2:
            ///Procesar pago de tarjeta
            if(!$("#card-form")[0].checkValidity()){
                $("#collapse1").removeClass("show");
                $("#collapse2").removeClass("show");
                $("#collapse3").addClass("show");

                $("#collapseTwo").addClass("show");

                let toast = $("#toast-tarjeta");
                toast.show();
                toast.find("#mensaje").html("Verifica los datos de tu tarjeta");
                toast.toast('show');
                toast.on('hidden.bs.toast',function(){
                    toast.hide();
                });

                boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
                boton.prop("disabled",false);
                break;
            }

            crearToken();
            break;
        case 3:
            ///Porcesar pago por paypal
            if($("#paypalTokenOrder").val() == "" || $( "#paypalTokenOrder" ).length <=0){
                mostrarModal("Para pagar con Paypal necesitas darle click al botón amarillo 'Paypal', loggearte y aceptar la transacción",0);

                boton.css({ 'background-color': '#dc3545', 'border-color': '#dc3545' });
                boton.prop("disabled",false);
                break;
            }

            mandarFormulario();
            break;
    }
    
}