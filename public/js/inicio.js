$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});

$(document).ready(function(){
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        //console.log("Clickeaste la pafinacion y su pagina es");
        //console.log($(this).attr('href').split('p=')[1]);
        
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        
        var page=$(this).attr('href').split('p=')[1];
        
        getData(page);
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
/*
    var categorias = document.getElementsByClassName("categoria");
    for(let a = 1; a < categorias.length; a++){
        console.log("hola");
        
        categorias[a].addEventListener("click", function(event){
            event.preventDefault();
            getDataByCategorie(1);
        });
    }*/

    $(document).on('click', '.categoria',function(event){
        event.preventDefault();
            getDataByCategorie(1);
    });
});

function getDataByCategorie(id){
    console.log("gg");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url: window.location.href+'vGxWbRowQT',
        data:{}
    }).done(function(data){
        $("#paginador").empty().html(data);
        //location.hash = 2;
    });
}

function getData(page){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'GET',
        url: '?p=' + page,
        data:{}
    }).done(function(data){
        $("#paginador").empty().html(data);
        //location.hash = page;
    });
}