$(document).ready(function(){
    //Toast de mensaje de alert, succes o warning
    if($("#myToast") != null) $("#myToast").toast('show');
});

grecaptcha.ready(function() {
    grecaptcha.execute('6LfQSLUUAAAAACQOzseZ3J9wWIEg1v5iU0Rtgnv9', {action: 'homepage'}).then(function(token) {
    });
});