$(document).ready(function(){
    //Formulario de producto
    //Trae las subcategorias, cuando se elige una sub categoria
    $("#producto-categoria").change(function(){
        let id = $("#producto-categoria").val();
        id =  parseInt(id);
        getSubCategorias(id);
    });

    //Paginacion de la tabla
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        var page = myurl.split('p=')[1];
        var cadena=$("#producto-actual").val();

        buscarProductos(cadena,page);
    });

    //Evento ajax de buscar producto
    $(document).on('search', '#producto-busca',function(event){ 
        var buscar = $('#producto-busca').val();
        
        buscarProductos(buscar,1);
    }); 

    $(document).on('submit', '#buscarProducto',function(event){
        event.preventDefault();
    });
});

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
    }).done(function(data){ console.log(data);
        let subCategorias = "";
        
        if(data != null){
            for(let a=0; a<data.length; a++){
                subCategorias += "<option value='"+data[a]['idcategorias']+"'>"+data[a]['nombre']+"</option>";
            }
        }
        $("#producto-subcategoria").html("<option value=''>Sin subcategoria</option>"+subCategorias);
    });
} 

function buscarProductos(cadena,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaProductos').val(),
        data:{cadena:cadena,p:page}
    }).done(function(data){
        //console.log(data);
        $("#del-producto-form").empty().html(data.tabla);   

        $('#producto-busca').focus();
        var datos =  $('#producto-busca').val();
        $('#producto-busca').val("").val(datos);

        var busqueda = $('#producto-actual').val();
        if(busqueda != ""){ //Esto implica una busqueda 
            var nombres = $(".nombre-producto");
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