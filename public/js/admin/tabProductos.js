$(document).ready(function(){

    //Formulario de producto
    //Trae las subcategorias, cuando se elige una sub categoria
    $("#producto-categoria").change(function(){
        let id = $("#producto-categoria").val();
        id =  parseInt(id);
        getSubCategorias(id);
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