$(document).ready(function(){

    //Modal de eliminar banners
    $(document).on('show.bs.modal','#modalBanners',function(event){
        var nombreFoto = $(".carousel-item.active").first().data("nombre");
        var urlFoto = $(".carousel-item.active").first().children().first().attr("src");

        var modal = $(this);

        modal.find('#banner-nombre').val(nombreFoto);
        modal.find('#div-banner-mensaje').html('¿Estas seguro de eliminar el banner '+nombreFoto+'?<br><img src="'+urlFoto+'" class="d-block w-100" alt="...">');
    });
});