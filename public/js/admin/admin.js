$(document).ready(function(){
    //Toast de mensaje de alert, succes o warning
    if($("#myToast") != null) $("#myToast").toast('show');

    

    //Paginacion de la tabla marcas y categorias
    /*
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        
        var idVentana = $('.tab-pane.fade.show.active')[0].id;

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        
        var page ="";

        if(idVentana == 'nav-marcas'){
            console.log('gg0');
            page= myurl.split('pM=')[1];
            page = 2;
            var cadena=$("#marca-actual").val();
            buscarMarcas(cadena,page);
        }else{

            page=$(this).attr('href').split('pC=')[1];
        }
       
    });*/

    
});



