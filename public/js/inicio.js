/*$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            var id = $("#paginador-idCat").val();
            getDataByCategorie(id,page);
        }
    }
});
*/
$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        
        var page=$(this).attr('href').split('p=')[1];
        
        var id = $("#paginador-idCat").val();
        console.log(page);
        console.log(id);
        getDataByCategorie(id,page);
    });

    //* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            } else {
            dropdownContent.style.display = "block";
            }
        });
    }

    $(document).on('click', '.categoria',function(event){
        var id = $(this).children().val();
        event.preventDefault();

        let nameCat = $(this).attr("nombreCat");
        let idCat = $(this).attr("idCat");
        let nameSubCat = "";

        if($(this).hasClass("subCategoria") ){
            nameSubCat = $(this).attr("nombreSubCat");
        }
    
        goToBreadcrumb(id,nameCat,nameSubCat,idCat);
    });
});

function goToBreadcrumb(id, categoria, subcategoria, idCategoria){
    let emptyString = "''";

    $("#directorio").html('<li class="breadcrumb-item" id="breadcrum-init"><a href="#" onclick="goToBreadcrumb(0,'+emptyString+','+emptyString+');">GB Shop Music Store</a></li>');
        
    if(subcategoria != ""){
        let categoria1=  categoria;
        categoria = "'"+categoria+"'";
        $("#directorio").append('<li class="breadcrumb-item" id="breadcrum-init"><a href="#" onclick="goToBreadcrumb('+idCategoria+','+categoria+','+emptyString+');">'+categoria1+'</a></li>');
        $("#directorio").append('<li class="breadcrumb-item active" aria-current="page">'+subcategoria+'</li>');
    }else{
        if(categoria != ""){
            $("#directorio").append('<li class="breadcrumb-item active" aria-current="page">'+categoria+'</li>');
        }
    }

    getDataByCategorie(id,1);
}

function getDataByCategorie(id,page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaProductos').val()+'?p=' + page,
        data:{id: id}
    }).done(function(data){
        $("#paginador").empty().html(data);
        $("#paginador-idCat").val(id);
        window.scrollTo(0,0);
    });
}