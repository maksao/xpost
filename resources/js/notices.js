/*
    требуется подключения jquery-toast
    v.2.0
 */
global.notices = {

    // Вывод всплывающего сообщения с подтверждением (success)
    success : function (message)
    {
        $.toast({
            heading: 'Успех',
            text: message,
            showHideTransition: 'fade',
            bgColor: '#28a745',
            position: 'bottom-left',
            icon: 'success'
        });
    },

    // Вывод всплывающего сообщения с предупреждением
    warning : function (message) {
        $.toast({
            heading: 'Внимание',
            text: message,
            showHideTransition: 'fade',
            bgColor: '#fd7e14',
            position: 'bottom-left',
            hideAfter: false,
            icon: 'warning'
        });
    },

    // Вывод всплывающего сообщения с ошибкой
    error : function (message) {
        $.toast({
            heading: 'Ошибка',
            text: message,
            showHideTransition: 'slide',
            bgColor: '#dc3545',
            position: 'bottom-left',
            hideAfter: false,
            icon: 'error'
        });
    },

    // Вывод всплывающего сообщения с информацией
    info : function (message) {
        $.toast({
            heading: 'Информация',
            text: message,
            showHideTransition: 'fade',
            bgColor: '#17a2b8',
            position: 'bottom-left',
            icon: 'info'
        });
    },

    // Вывод всплывающего сообщения (темный фон)
    default : function (message) {
        $.toast({
            text: message,
            showHideTransition: 'fade',
            position: 'bottom-left'
        });
    },

    // Вывод всплывающего сообщения с ошибкой при возврате от ajax запроса
    responseError : function (xhr) {
        let message = '';
        if (xhr.status === 403) {
            message = 'Данное действие Вам недоступно.';
        } else {
            if (xhr.responseJSON['message'].length && xhr.responseJSON['message'] !== 'The given data was invalid.') {
                message = '<div>----' + xhr.responseJSON['message'] + '</div>';
            }
            $.each(xhr.responseJSON['errors'], function (index, element) {
                message += element + '</br>';
            });

        }
        this.error(message);
    }
}