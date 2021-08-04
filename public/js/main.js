$(document).ready(function (e) {

    $('#hamburger-button').on('click', function(){
        $('#menuResponsive').slideToggle();
    });


    $('.animated').each(function(){
        $(this).checkAnimation();
    });

    //Fonction qui permet d'afficher le bouton de déconnexion dans l'espace admin lors du click
    $(document).click(function(event) {
        if(!$(event.target).closest('.hoverDeco').length) {
            $('.Deco').hide();
        }
        else {
            $('.Deco').toggle();
        }

    });

});

$.fn.checkAnimation = function() {

    function isElementInViewport($elem) {
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        var elemTop = Math.round( $elem.offset().top );
        var elemBottom = elemTop + $elem.height();

        return (elemTop < viewportBottom);
    }

    function checkAnimation() {
        var $elem = $(this);
        if ($elem.hasClass('start')) return;

        if (isElementInViewport($elem)) {
            $elem.addClass('start');
            $elem.addClass($elem.data('animation'));
        }
    }
    return this.each(checkAnimation);
};


$(window).scroll(function(){
    $('.animated').each(function(){
        $(this).checkAnimation();
    });
})

$(".backstretch").each(function(){
    var image = $(this).data('img');
    $(this).backstretch(image);
});


if (window.matchMedia("(max-width: 950px)").matches) {

    $('.dropdown_text_content').addClass('text-red');
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    var iOSnbClicks = 0;

    if(!iOS){
        var nb_clicks_button_agence = 0;
        $(window).click(function(e) {
            if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence < 1){
                nb_clicks_button_agence++;
                $('#navbar_evenements_button').css('margin-top', '90px');
                e.preventDefault();
            }else if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence == 1){
                nb_clicks_button_agence = 0;
                document.location.href = $('#navbar_button_agence').attr('href');
            }else{
                nb_clicks_button_agence = 0;
                $('#navbar_evenements_button').css('margin-top', '0px');
            }
        });

    }else{
        let touchEvent = 'ontouchend' in window ? 'touchend' : 'click';
        var nb_clicks_button_agence_ios = 0;
        $(window).on(touchEvent, function(e){
            if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence_ios < 1){
                nb_clicks_button_agence_ios++;
                $('#navbar_evenements_button').css('margin-top', '90px');
                e.preventDefault();
            }else if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence_ios == 1){
                nb_clicks_button_agence_ios = 0;
                document.location.href = $('#navbar_button_agence').attr('href');
            }else{
                nb_clicks_button_agence_ios = 0;
                $('#navbar_evenements_button').css('margin-top', '0px');
            }
        });
    }
}


window.onresize = function(){
    if (window.matchMedia("(max-width: 950px)").matches) {

        $('.dropdown_text_content').addClass('text-red');
        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        var iOSnbClicks = 0;

        if(!iOS){
            var nb_clicks_button_agence = 0;
            $(window).click(function(e) {
                if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence < 1){
                    nb_clicks_button_agence++;
                    $('#navbar_evenements_button').css('margin-top', '90px');
                    e.preventDefault();
                }else if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence == 1){
                    nb_clicks_button_agence = 0;
                    document.location.href = $('#navbar_button_agence').attr('href');
                }else{
                    nb_clicks_button_agence = 0;
                    $('#navbar_evenements_button').css('margin-top', '0px');
                }
            });
        }else{
            let touchEvent = 'ontouchend' in window ? 'touchend' : 'click';
            var nb_clicks_button_agence_ios = 0;
            $(window).on(touchEvent, function(e){
                if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence_ios < 1){
                    nb_clicks_button_agence_ios++;
                    $('#navbar_evenements_button').css('margin-top', '90px');
                    e.preventDefault();
                }else if(e.target.id == 'navbar_button_agence' && nb_clicks_button_agence_ios == 1){
                    nb_clicks_button_agence_ios = 0;
                    document.location.href = $('#navbar_button_agence').attr('href');
                }else{
                    nb_clicks_button_agence_ios = 0;
                    $('#navbar_evenements_button').css('margin-top', '0px');
                }
            });
        }
    }

}
