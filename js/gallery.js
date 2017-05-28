/**
 * Created by armen on 21.05.17.
 */
$(function() {
    $('.pop').on('click', function() {
        $('.imagepreview').attr('src', $(this).find('img').attr('data-large_img_url'));
        console.log($(this).find('img').attr('alt'));
        $('.modal-header span').textContent = $(this).find('img').attr('alt');
        $('#imagemodal').modal('show');
    });
    $('.close').on('click', function() {
        $('.imagepreview').attr('src', '');
    });

});
