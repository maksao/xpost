{{--
    1.0
    Поле ввода с добавками до и после поля
--}}
@component( 'components.forms.plain.wrapper', get_defined_vars()['__data'] )
    <div class="input-group">
        @isset($prepend)
            <div class="input-group-prepend">{{ $prepend }}</div>
        @endisset
        @if($type == 'file')
            @include('components.forms.elements.file_browser')
        @else
            @include('components.forms.elements.input')
        @endif
        @isset($append)
            <div class="input-group-append">{{ $append }}</div>
        @endisset
    </div>
@endcomponent