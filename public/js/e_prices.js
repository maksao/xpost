$(function () {

    // Фильтры: При выборе статуса заказано поставщиком
    // Прячет или отображает галку "показать только просроченные"
    $('[data-toggle="add-to-products"]').on('click', function(e){
        e.preventDefault();

        // параметр k явяется ключом для API аутентификации в middleware AllowAccess

        $.get('/api/price/' + $(this).data('id'), {k : '64B2'}, function(data) {
            var dialog = $('#mProductCreate'),
                price_data = data.data;

            // Заполняем форму добавления
            dialog.find('input[name="article"]').val(price_data.article);
            dialog.find('select[name="brand_id"] option[value=' + price_data.brand_id + ']').prop('selected', true);
            dialog.find('input[name="name_eng"]').val(price_data.name);
            dialog.find('input[name="weight"]').val(price_data.weight);
            dialog.find('input[name="comment"]').val(price_data.comment);

            dialog.modal('show');
            //console.log(price_data.brand_id);
        }).fail(function(xhr){
            notices.responseError(xhr);
        });

    });

});
