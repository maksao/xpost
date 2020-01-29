// v.1.0
$(function () {
    // токен для запросов Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // отключаем кеширование Ajax запросов
        cache : false
    });

    // всплывающие подсказки
    $('[data-toggle="tooltip"]').tooltip();

    // информеры открывающиеся при наведении мышью
    $('[data-toggle="popover"]').popover({
        trigger : 'hover',
        placement : 'top'
    });

    // отметка всех
    $('[data-action="check-all"]').on('click', function(){
        $('input[data-action="check-row"]').prop('checked', $(this).prop('checked'));
    });

    // отметка/дезотметка галкой по клику по ссылке в выпадающем меню
    $('[data-toggle="check-rows-all"]').on('click', function(e){
        e.preventDefault();
        var check = $(this).data('check'),
            checkboxesSelector = 'input[id=ids]',
            checkboxes = $(checkboxesSelector),
            mainCheckbox = $("input[data-action='check-all']");

        // Снимаем отметки со всех
        mainCheckbox.prop('checked', '');
        checkboxes.prop('checked', '');

        if(check === 'all'){
            mainCheckbox.prop('checked', 'checked');
            checkboxes.prop('checked', 'checked');
        }
    });

    // диалог подтверждения
    $('[data-toggle="dialog-confirm"]').on('click', function(e) {
        e.preventDefault();
        var $dialog = $('#dConfirm');
        $dialog.find('form').attr('action', $(this).data('url') ? $(this).data('url') : $(this).attr('href') );
        if($(this).data('text')){
            $dialog.find('.modal-body').html($(this).data('text') );
        }
        // если надо проверить какая ссылка передается
        // $('.debug-url').html('Delete URL: <strong>' + $dialog.find('form').attr('action') + '</strong>');
        $dialog.modal('show');
    });

    // диалог подтверждения 2.0
    $('[data-confirm]').on('click', function (e) {
        e.preventDefault();
        var $dialog = $('#dConfirm'),
            method = $(this).data('confirm');
        if(method === 'post') {
            $('#m-post').removeClass('d-none');
            $('#m-get').addClass('d-none');
            $dialog.find('form')
                .attr('action', $(this).data('url') ? $(this).data('url') : $(this).attr('href'))
                .attr('method', method)
            ;
        } else {
            $('#m-post').addClass('d-none');
            $('#m-get').removeClass('d-none');
            $dialog.find('a#confirm').attr('href', $(this).data('url') ? $(this).data('url') : $(this).attr('href'));
        }
        if($(this).data('text')){
            $dialog.find('.modal-body').html($(this).data('text') );
        }
        $dialog.modal('show');
    });

    // подтверждение удаления
    $('[data-toggle="confirm-delete"]').on('click', function(e) {
        e.preventDefault();
        var $dialog = $('#dConfirmDelete'),
            url = $(this).data('href') ? $(this).data('href') : $(this).attr('href');
        $dialog.find('form').attr('action', url );
        if($(this).data('text')){
            $dialog.find('.modal-body').html($(this).data('text') );
        }
        // если надо проверить какая ссылка передается
        // $('.debug-url').html('Delete URL: <strong>' + $dialog.find('form').attr('action') + '</strong>');
        $dialog.modal('show');
    });

    // Отображение модального окра с контентом из другого(скрытого) блока

    $('body').on('click', '[data-toggle="modal-info"]', function(){
        let el = $(this),
            dialog = $(el.data('modal') ? el.data('modal') : '#dInfo');

        dialog.find('.modal-title').html( el.data('title') );
        dialog.find('#modal-body-content').html( $(el.data('target')).html() );
        dialog.modal('show');
    });

    // удаление отмеченных

    $('[data-action="delete-checked"]').on('click', function(e){
        e.preventDefault();
        var form = $('#checked-actions-form');
        if( ! $('input[type=checkbox]:checked[form="checked-actions-form"]').length ){
            notices.warning('Нужно выбрать хотябы одну запись');
            return;
        }
        form.attr('action', $(this).attr('href'));

        var $dialog = $('#dConfirmDelete');
        $dialog.find('[type="submit"]').attr('form', 'checked-actions-form' );
        $dialog.modal('show');
    });


    // какое-то действие с отмеченными

    $('[data-action="with-checked"]').on('click', function(e){
        e.preventDefault();
        var form = $('#checked-actions-form');
        if( ! $('input[type=checkbox]:checked[form="checked-actions-form"]').length ){
            notices.warning('Нужно выбрать хотябы одну запись');
            return;
        }
        form.attr('action', $(this).attr('href')).submit();
    });

    // копирование текста в буфер обмена

    $('[data-clipboard="copy"]').on('click', function(){
        let $temp = $("<input>");
        $("body").append($temp);
        $temp.val($($(this).data('clipboard-target')).text()).select();
        document.execCommand("copy");
        $temp.remove();
        notices.success('Данные скопированы в буфер обмена. Используйте Ctrl+V чтобы вставить содержимое в нужном месте.')
    });

    // прокрутка на начало страницы
    $(window).scroll(function()
    {
        if($(this).scrollTop() > 50){
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });


    $('#toTop').click(function()
    {
        $('body,html').animate({scrollTop:0},200);
    });

	// Переключение флажка при сворачивании/разворачивании
    $('i[data-toggle="collapse"]').click(function () {
        $(this).toggleClass('fa-caret-down fa-caret-right');
    });

    // для поиска без учета регистра
    $.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
        return function( elem ) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    // Отмена закрытия списка при клике
    $('.dropdown-text, .dropdown-info ').click(function (e) {
        e.stopPropagation();
    });

});
