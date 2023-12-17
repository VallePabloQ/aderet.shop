jQuery(document).ready(function($) {
    var alturaNecesaria = 220; // Ajusta la altura a partir de la cual deseas agregar la clase

    $(window).scroll(function() {
        if ($(this).scrollTop() > alturaNecesaria) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });
});
