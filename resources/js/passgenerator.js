$(function () {

    $('[data-toggle="generate-password"]').on('click', function(e){
        var pass = str_rand()
        $('input[name="password"]').val(pass);
        $('input[name="password_confirmation"]').val(pass);
    });

});

function str_rand() {
    var result       = '';
    var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    var max_position = words.length - 1;
    for( i = 0; i < 10; ++i ) {
        position = Math.floor ( Math.random() * max_position );
        result = result + words.substring(position, position + 1);
    }
    return result;
}