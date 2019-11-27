$(document).ready(function(){
    //Toast de mensaje de alert, succes o warning
    if($("#myToast") != null) $("#myToast").toast('show');
});

/*
function changeProducto(codigo,cantidad){

    cambiarProducto(codigo,cantidad);
} */
var boton ;
function changeProducto(codigo,cantidad,idFila){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaCarrito').val(),
        data:{codigo:codigo,cantidad:cantidad}
    }).done(function(data){
        //console.log(data);
        boton = data;
        if(data['codigo'] == 200){ //Hubo exito al modificar el carrito
            let id = "#"+String(idFila)+"cantidadProducto";
            $(id).html(data['cantidad']);

            id = "#"+String(idFila)+"detalleValor";
            $(id).html("$"+data['subtotal']);

            if(data['envioSF'] > 0){
                $("#valorEnvio").removeClass("texto-promo");
                $("#valorEnvio").html("$"+data['envio']);
            }else{
                $("#valorEnvio").addClass("texto-promo");
                $("#valorEnvio").html("GRATIS");
            }

            $("#carrito-total").html("$"+data["total"]);
        }
    });
}