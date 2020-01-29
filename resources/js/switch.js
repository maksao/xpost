$(function () {
    $('[data-toggle="switch-checkbox"]').on('click', function(){
        var el = $(this);
        $.get( el.data('url'), function(data){
            notices.success('Сохранено.');
        }).fail(function(xhr){
            notices.responseError(xhr);
            el.prop('checked', !el.is(':checked'));
        });
    });

});