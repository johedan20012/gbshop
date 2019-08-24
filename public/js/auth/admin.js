$(document).ready(function(){
    //Toast de mensaje de alert, succes o warning
    if($("#myToast") != null) $("#myToast").toast('show');

    //Formulario de producto
    $("#producto-categoria").change(function(){
        getSubCategorias($("#producto-categoria").val());
    });

    //Paginacion de la tabla marcas y categorias
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
       
    });

    var timeout = null;

    //Buscador de marcas
    $(document).on('keyup', '#marca-busca',function(event){ 

        clearTimeout(timeout);

        timeout = setTimeout(function () {
            var buscar = $('#marca-busca').val();

            buscarMarcas(buscar,1);
        }, 500);
        
    });

    //Buscador de marcas
    $(document).on('search', '#marca-busca',function(event){ 

        clearTimeout(timeout);

        timeout = setTimeout(function () {
            var buscar = $('#marca-busca').val();

            buscarMarcas(buscar,1);
        }, 500);
        
    });

    //Evento ajax de buscar marca
    $(document).on('submit', '#buscarMarca',function(event){
        event.preventDefault();
    });

    //Modal de editar y/o eliminar marcas
    $(document).on('show.bs.modal','#modalEditarMarcas',function(event){
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var nombre = button.data('nombre');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        //modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('#marca-id').val(id);
        modal.find('#marca-nombre').val(nombre);
    });
    $(document).on('show.bs.modal','#modalBorrarMarcas',function(event){
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var nombre = button.data('nombre');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        //modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('#marca-id').val(id);
        modal.find('#message-modalMarcas').html( '¿Eliminar la marca "' + nombre + '"?');
    });
});

function buscarMarcas(cadena,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'GET',
        url: $('#rutaMarcas').val()+'?pM='+page+'&cadena=' + cadena,
        data:{}
    }).done(function(data){
        console.log(data);
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
                    console.log(indice + " " +indices[i]);
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

function getSubCategorias(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaSubCategorias').val(),
        data: {id:id}
    }).done(function(data){
        let subCategorias = "";
        
        if(data != null){
            for(let a=0; a<data.length; a++){
                subCategorias += "<option value='"+data[a]['idcategorias']+"'>"+data[a]['nombre']+"</option>";
            }
        }
        $("#producto-subcategoria").html("<option value=''>Seleccione una opción...</option>"+subCategorias);
    });
} 