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

    //Modal de editar y/o eliminar productos
    $(document).on('show.bs.modal','#modalProductos',function(event){
        var button = $(event.relatedTarget); // Obtiene el boton que activo al modal
        var id = button.data('id'); // Obtiene los datos de los atributos data-*
        var nombre = $("#"+id+"nombre").text();
        var ruta = (button.data('type') == 2) ?  $('#rutaDelProducto').val() : $('#rutaEditProducto').val();
        var modal = $(this);

        modal.find('#producto-id').val(id);
        modal.find('#form-modal-producto').attr('action',ruta);
        modal.find('#modal-form-fotos').removeClass("show");

        if(button.data('type') == 2){
            modal.find("#editarProducto").hide();
            modal.find("#borrarProducto").show();
            modal.find('#modalProductosLabel').html('Eliminar producto');
            modal.find('#borrarProducto').html('¿Eliminar el producto "'+nombre+'"? SE BORRARAN TODAS LAS FOTOS DE ESTE PRODUCTO');
        }else{
            modal.find("#editarProducto").show();
            modal.find("#borrarProducto").hide();
            modal.find('#modalProductosLabel').html('Modificar producto');
            
            $formModal = $("#form-modal-producto");
            let desc = $("#"+id+"desc").text();
            let marca = button.data('marca');
            let categoria = button.data('categoria');
            let categoriaPadre = ($("#"+id+"categoriaPadre")[0] != null)? $("#"+id+"categoriaPadre").val() : -1;
            let precio = $("#"+id+"precio").val();

            $formModal.find("#producto-nombre").val(nombre);
            $formModal.find("#producto-descripcion").val(desc);
            $formModal.find("#producto-marca").val(marca);
            $formModal.find("#producto-precio").val(precio);
            console.log(id);
            $formModal.find("#producto-id").val(id);
            
            if(categoriaPadre != -1){ //Su categoria es una subcategoria
                $formModal.find("#producto-categoria").val(categoriaPadre);
                getSubCategorias(categoriaPadre,$formModal.find("#producto-subcategoria2"),categoria);
            }else{  //Su categoria es una categoria padre
                $formModal.find("#producto-categoria").val(categoria);
            }

            $("#producto-fotosBorrar").val("");
            getFotosProducto(id);

            $formModal.find("#producto-categoria").change(function(){
                let id = $(this).val();
                id =  parseInt(id);
                getSubCategorias(id,$("#producto-subcategoria2"),"");
            });
        }
    });
});

function getSubCategorias(id,campoForm = null,opcion = null){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaSubCategorias').val(),
        data: {id:id}
    }).done(function(data){ //console.log(data);
        let subCategorias = "";
        
        if(data != null){
            for(let a=0; a<data.length; a++){
                subCategorias += "<option value='"+data[a]['idcategorias']+"'>"+data[a]['nombre']+"</option>";
            }
        }
        if(campoForm != null) {
            campoForm.html("<option value=''>Sin subcategoria</option>"+subCategorias);
            if(opcion != null) campoForm.val(opcion);
        }else{
            $("#producto-subcategoria").html("<option value=''>Sin subcategoria</option>"+subCategorias);
        }
    });
} 

function getFotosProducto(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaFotosProducto').val(),
        data: {id:id}
    }).done(function(data){ //console.log(data);
        let formModal = $("#form-modal-producto");

        if(data == "error"){
            formModal.find("#modal-form-fotos").html("Error al cargar las imagenes de este producto");
            return; //Algo fallo
        }

        let imagenes = "";
        let nombresFotos = "";
        let aux = "";
        for(let a = 0; a<data.length && a<10; a++){
            if(a == 4 || a == 8){
                imagenes += '<div class="row col-12 col-md-12 col-sm-12">'+aux+'</div>';
                aux = "";
            }

            aux += '<div class="col-3 col-md-3 col-sm-3" style="position: relative;"  id ="'+a+'divImgModal">'; 
            aux+= '<img class="imgModalThumb" src="'+data[a][0]+'" style="width:60px; height:60px;" title="Imagen '+a+'"></img>';
            aux += '<a href="#" data-id="'+a+'" data-nombre="'+data[a][1]+'" class="aImgModalThumb" style="color: black; position: absolute; top:0; right:0;"><i class="fas fa-times" style="color: red;"></i></a>';
            aux += '</div>';
            if(nombresFotos != ""){
                nombresFotos += ",";   
            }
            nombresFotos += data[a][1];
        }
        if(aux != ""){
            imagenes += '<div class="row col-12 col-md-12 col-sm-12">'+aux+'</div>';
                aux = "";
        }

        
        imagenes += '<input type="hidden" value="'+nombresFotos+'" id="modal-nombreFotos" name="producto-fotosActuales">';
        formModal.find("#modal-form-fotos").html(imagenes);

        $(".aImgModalThumb").click(function(event){
            event.preventDefault();

            let arreglo = $("#modal-nombreFotos").val().split(",");

            for(let a =0; a<arreglo.length; a++){
                if ( arreglo[a] == $(this).data('nombre')) {
                    let fBorrar = $("#producto-fotosBorrar").val();
                    if(fBorrar != ""){
                        fBorrar += ",";
                    }
                    fBorrar += arreglo[a];
                    $("#producto-fotosBorrar").val(fBorrar);
                    arreglo.splice(a, 1); 
                    a--;
                }
            }
            $("#modal-nombreFotos").val(arreglo.join());
            $("#"+$(this).data('id')+"divImgModal").hide();
        });
        
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
                var cadena = nombres.eq(a).text(),cadenaLower = cadena.toLowerCase();

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