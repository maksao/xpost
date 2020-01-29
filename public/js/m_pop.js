$(function () {
    m_pop.init();
});

var m_pop = {

    init : () => {
        $('[data-toggle="mp-confirm"]').on('click', function(e) {
            e.preventDefault();
            notices.info('Окно с подтверждением');
        });
    },

    notice :  {

        success : (msg) => {
            this.show({
                'type' : 'success',
                'message' : msg
            })
        },

        error : () => {
            alert('Error');
        },

        show : (params) => {

            if( !$('#m-pop-div') ){
                $('<div>', { id: 'm-pop-div'}).appendTo('body');
            }
            alert('Тут');

        }
    },



};
