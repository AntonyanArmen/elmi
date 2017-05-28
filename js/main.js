$(function(){
    var offset = $(".templatemo-nav").height();
    $('.templatemo-nav').singlePageNav({
        offset: offset,
        filter: ':not(.external)',
        updateHash: false
    });

});
