$(function () {

    // Фильтры: При выборе статуса заказано поставщиком
    // Прячет или отображает галку "показать только просроченные"
    $('[data-toggle="m-update"]').on('click', function(e){
        e.preventDefault();
        $('#mProductUpdate').find('form').attr('action', $(this).attr('href'));

        // параметр k явяется ключом для API аутентификации в middleware AllowAccess

        $.get('/api/products/' + $(this).data('id'), {k : '64B2'}, function(data) {
            var dialog = $('#mProductUpdate'),
                product = data.data;

            // Заполняем форму добавления
            dialog.find('#article').html(product.article);
            dialog.find('#brand').html(product.brand.name);
            dialog.find('input[name="name_eng"]').val(product.name_eng);
            dialog.find('input[name="name_rus"]').val(product.name_rus);
            dialog.find('input[name="weight"]').val(product.weight);
            dialog.find('input[name="url"]').val(product.url);
            dialog.find('input[name="comment"]').val(product.comment);

            dialog.modal('show');
            //console.log(product.brand_id);
        }).fail(function(xhr){
            notices.responseError(xhr);
        });

    });

});
