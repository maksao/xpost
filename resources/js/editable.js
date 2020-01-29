/**
 *  Требуется:
 *  механизм всплывающих сообщений (notices.js)
 *  шаблоны модального окна
 *  открытие окна срабатывает на элементах с классом - .editable
 *
 *  v.1.0
 */

$(function () {
    editable.init();
});

var editable = {

    // редактируемый блок
    block : null,

    // Окно диалога
    modalId : '#editableModal',
    dialog : null,

    // Форма диалога
    formId : '#editableModalForm',
    form : null,

    // Тело формы диалога
    formBodyId : '#editableModalFormBody',
    formBody : null,

    ajax : false,

    // Допустимые типы данных
    allowed_types : [
        'text',
        'number',
        'textarea',
        'price',
        'phone',
        'email',
        'date'
    ],

    init : function(config){
        //$.extend(editable.config, config); // это так, на память
        // Находим модальное окно и форму
        editable.dialog = $(editable.modalId);
        editable.form = editable.dialog.find(editable.formId);
        editable.formBody = editable.form.find(editable.formBodyId);

        // Регистрируем слушатель события
        $('body').on('click', '.editable', function(){ editable.processing($(this)); });
        // Сабмит формы
        editable.form.on('submit', function(e){  editable.onSubmit(e); });
        // editable.form.on('submit', editable.onSubmit);
        // editable.dialog.find('#submitButton').on('click', function(){  editable.onSubmit(); });
    },

    processing : function(el) { // el - элемент по которому был клик
        var f_type = 'text', field;
        this.block = el;
        // Тип запроса ajax или нет
        this.ajax = el.data('ajax') === 1;

        // Проверяем тип данных
        if( el.is('[data-type]') ){
            if($.inArray(el.data('type'), this.allowed_types) > -1) {
                f_type = el.data('type');
            } else {
                this.showNotice('error', 'Неизвестный тип данных');
                return;
            }
        }

        let
            // title
            title = el.is('[data-title]') ? el.data('title') : 'Редактирование',

            // URL
            url = el.is('[data-url]') ? el.data('url') : '',

            // id
            f_id = el.is('[data-id]') ? ' id=' + el.data('id') : '',

            // name
            f_name = el.is('[data-name]') ? ' name=' + el.data('name') : '',

            // value
            f_content = el.is('[data-value]') ? el.data('value').toString()  : el.html(),
            f_value = ' value="' + $.trim(f_content.replace(/"/g, '&quot;')) + '"',

            // Required
            f_required = el.data('required') === false ? ''  : ' required',

            // Attr
            f_attr = el.is('[data-attr]') ? el.data('attr') : '',

            // Common
            f_common = ' id="form-data" class="form-control form-control-sm"';

        if( f_type === 'text' ) {
            field = $('<input type="text"'
                + f_common
                + f_id
                + f_name
                + f_value
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'number' ) {
            field = $('<input type="number"'
                + f_common
                + f_id
                + f_name
                + f_value
                + ' pattern="\\d+?"'
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'price' ) {
            field = $('<input type="text"'
                + f_common
                + f_id
                + f_name
                + f_value
                + ' pattern="\\d+(\\.\\d{1,2})?"'
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'phone' ) {
            field = $('<input type="text"'
                + f_common
                + f_id
                + f_name
                + f_value
                + ' pattern="^\\+7\\d+?"'
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'email' ) {
            field = $('<input type="email"'
                + f_common
                + f_id
                + f_name
                + f_value
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'date' ) {
            var f_date = new Date($.trim(f_content.replace(/"/g, '&quot;'))),
                day = f_date.getDate(),
                month = f_date.getMonth() + 1,
                year = f_date.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            f_value = ' value="' + year  + '-' + day + '-' + month + '"';
            field = $('<input type="date"'
                + f_common
                + f_id
                + f_name
                + f_value
                + f_attr
                + f_required
                + '>');
        }else if( f_type === 'textarea' ) {
            field = $('<textarea rows="4"'
                + f_common
                + f_id
                + f_name
                + f_attr
                + f_required
                + '>'
                + f_content
                + '</textarea>');
        }

        // Собираем и отображаем окно диалога

        // Заголовок
        this.dialog.find('.modal-title').html(title);

        // Форма
        this.form.attr('action', url);
        this.formBody.html('').append(field);

        this.dialog.on('shown.bs.modal', function () {
            field.trigger('focus')
        });

        this.dialog.modal('show');
    },

    onSubmit : function(e) {
        // Если запрос ajax то тормозимся и обрабатываем форму
        if( this.ajax ) {
            e.preventDefault();
            this.processingAjaxRequest();
        }
    },

    processingAjaxRequest : function() {
        $.post( this.form.attr('action'),
            this.form.serialize(),
            function(){
                let data = editable.form.find('#form-data').val();
                if (data) {
                    if( editable.form.find('#form-data').attr('type') === 'date' ){
                        var f_date = new Date(data),
                            day = f_date.getDate(),
                            month = f_date.getMonth() + 1,
                            year = f_date.getFullYear();
                        if (day < 10) {
                            day = "0" + day;
                        }
                        if (month < 10) {
                            month = "0" + month;
                        }
                        data = day + '.' + month + '.' + year;
                    }
                    editable.block.html(data);
                } else {
                    editable.block.html('<i class="fa fa-plus-square"></i>');
                }
                editable.block.attr('data-value', data).data('value', data);
                editable.dialog.modal('hide');
                editable.showNotice('success','Данные обновлены');
            }
        ).fail(function(xhr){
            notices.responseError(xhr);
        });

        // this.dialog.modal('hide');
        // this.showNotice('error', 'Обработка запроса' );
        // this.dialog.modal('show');
    },

    showNotice : function(type = 'default', msg = 'Сообщение без текста') {
        if(type === 'success') {
            notices.success(msg);
        } else if (type === 'error') {
            notices.error(msg);
        } else if (type === 'info') {
            notices.info(msg);
        } else if (type === 'warning') {
            notices.warning(msg);
        } else {
            notices.default(msg);
        }
    }

};

