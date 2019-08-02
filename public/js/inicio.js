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
        console.log("Clickeaste la pafinacion y su pagina es");
        console.log($(this).attr('href').split('p=')[1]);
        
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        
        var page=$(this).attr('href').split('p=')[1];
        
        getData(page);
    });
});

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
        location.hash = page;
    });
}