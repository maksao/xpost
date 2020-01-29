{{--
    06.09.2017
    Статический текст
--}}
@component( 'components.forms.plain.wrapper', get_defined_vars()['__data'] )
    <div class="form-control-plaintext">{{ $slot }}</div>
@endcomponent