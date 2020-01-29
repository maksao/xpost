{{--

    v.1.0
    Поле ввода с добавками кнопок слева и/или справа

--}}
@component( 'components.forms.horizontal.wrapper', get_defined_vars()['__data'] )
    <div class="input-group">
        @isset($prepend)
            <div class="input-group-prepend">{{ $prepend }}</div>
        @endisset
        @include('components.forms.elements.input')
        @isset($append)
            <div class="input-group-append">{{ $append }}</div>
        @endisset
    </div>
@endcomponent
