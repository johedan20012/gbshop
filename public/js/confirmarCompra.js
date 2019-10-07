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
        console.log("Exito");
        console.log(token);
        /*var $form = $("#card-form");
        //Inserta el token_id en la forma para que se envíe al servidor
        $form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
        $form.get(0).submit(); *///Hace submit
    };
    conektaErrorResponseHandler = function(response) {
        console.log("Error"+response.message_to_purchaser);
       /* var $form = $("#card-form");
        $form.find(".card-errors").text(response.message_to_purchaser);
        $form.find("button").prop("disabled", false);*/
    };

    //jQuery para que genere el token después de dar click en submit
    $(function () {
        $("#card-form").submit(function(event) {
        var $form = $(this);
        // Previene hacer submit más de una vez
        $form.find("button").prop("disabled", true);
        Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
        return false;
        });
    });
});

function subir(event) {
    var $form = $(this);
    // Previene hacer submit más de una vez
    $form.find("button").prop("disabled", true);
    Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
    return false;
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
