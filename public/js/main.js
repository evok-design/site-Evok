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
        let viewportTop = $(window).scrollTop();
        let viewportBottom = viewportTop + $(window).height();

        let elemTop = Math.round( $elem.offset().top );
        let elemBottom = elemTop + $elem.height();

        return (elemTop < viewportBottom);
    }

    function checkAnimation() {
        let $elem = $(this);
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
    let image = $(this).data('img');
    $(this).backstretch(image);
});


if (window.matchMedia("(max-width: 950px)").matches) {

    $('.dropdown_text_content').addClass('text-red');
    let iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    let iOSnbClicks = 0;

    if(!iOS){
        let nb_clicks_button_agence = 0;
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
        let nb_clicks_button_agence_ios = 0;
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
        let iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        let iOSnbClicks = 0;

        if(!iOS){
            let nb_clicks_button_agence = 0;
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
            let nb_clicks_button_agence_ios = 0;
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
/*

let html = document.documentElement;
let body = document.body;

let scroller = {
    target: document.querySelector("#scroll-container"),
    ease: 0.07, // <= scroll speed
    endY: 0,
    y: 0,
    resizeRequest: 1,
    scrollRequest: 0,
};

let requestId = null;

TweenLite.set(scroller.target, {
    rotation: 0.01,
    force3D: true
});

window.addEventListener("load", onLoad);

function onLoad() {
    updateScroller();
    window.focus();
    window.addEventListener("resize", onResize);
    document.addEventListener("scroll", onScroll);
}

function updateScroller() {

    let resized = scroller.resizeRequest > 0;

    if (resized) {
        let height = scroller.target.clientHeight;
        body.style.height = height + "px";
        scroller.resizeRequest = 0;
    }

    let scrollY = window.pageYOffset || html.scrollTop || body.scrollTop || 0;

    scroller.endY = scrollY;
    scroller.y += (scrollY - scroller.y) * scroller.ease;

    if (Math.abs(scrollY - scroller.y) < 0.05 || resized) {
        scroller.y = scrollY;
        scroller.scrollRequest = 0;
    }

    TweenLite.set(scroller.target, {
        y: -scroller.y
    });

    requestId = scroller.scrollRequest > 0 ? requestAnimationFrame(updateScroller) : null;
}

function onScroll() {
    scroller.scrollRequest++;
    if (!requestId) {
        requestId = requestAnimationFrame(updateScroller);
    }
}

function onResize() {
    scroller.resizeRequest++;
    if (!requestId) {
        requestId = requestAnimationFrame(updateScroller);
    }
}

*/
