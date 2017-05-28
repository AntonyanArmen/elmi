/* HTML document is loaded. DOM is ready.
-------------------------------------------*/
$(function(){
    var offset = $(".templatemo-nav").height();
    /* start navigation top js */
    $(window).scroll(function(){
        if($(this).scrollTop()>offset ){
            $(".templatemo-nav").addClass("sticky");
        }
        else{
            $(".templatemo-nav").removeClass("sticky");
        }
    });
    $(window).show( function(){
        $(this).scrollTop(offset*2);
    });
    
    /* Hide mobile menu after clicking on a link
    -----------------------------------------------*/
    $('.navbar-collapse a').click(function(){
        $(".navbar-collapse").collapse('hide');
    });
    /* end navigation top js */

    $('body').bind('touchstart', function() {});

    /* wow
    -----------------*/
    new WOW().init();
});

/* start preloader */
$(window).load(function(){
	$('.preloader').fadeOut(1000); // set duration in brackets    
});
/* end preloader */
