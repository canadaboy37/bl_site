var selectedTableRow = null;

$(function() {
    $('.relationships-block .wrap').click(function() {
        $('.relationships-block .wrap.selected').removeClass('selected');
        $(this).addClass('selected');

        selectedTableRow = $(this).data('id');
    });
});