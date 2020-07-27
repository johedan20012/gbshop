$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        
        var page= myurl.split('p=')[1];
        var id = $("#categoria-actual").val();
        var cadena =$("#cadena-actual").val();
        
        getCatalogo(id,page,cadena);
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

});

function getCatalogo(id,page,cadena){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url: $('#rutaProductos').val(),
        data:{id:id,cadena:cadena,p:page}
    }).done(function(data){
        //console.log(data);
        $("#paginador").empty().html(data.tabla);
        $("#breadcr").empty().html(data.bread);
        
        $("#paginador-idCat").val(1);
        window.scrollTo(0,0);
        //console.log(window.location.href);
        //window.location.href=$('#rutaProductos').val()+'?id='+id;
        /*
        if (history.pushState) {
            //window.history.pushStatereplaceState("object or string", "Page Title", "/newURL"); //Navegadores modernos
            window.history.replaceState("object or string","", urle);
            //console.log(window.history);
            document.title=$("#last-categoria").html()+' | GB Route Music Store: Tienda online';
            
        } else {
            document.location.href = $('#rutaProductos').val()+'?id='+id+'&cadena='+cadena;
        }*/
    });
}