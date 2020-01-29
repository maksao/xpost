{{--
    17.08.2017
    Поле ввода с добавками до и после поля
--}}
@component( 'components.forms.horizontal.wrapper', get_defined_vars()['__data'] )
    <div class="input-group">
        @isset($addon_before)
            <span class="input-group-addon">{{ $addon_before }}</span>
        @endisset
        @include('components.forms.elements.input')
        @isset($addon_after)
            <span class="input-group-addon">{{ $addon_after }}</span>
        @endisset
    </div>
@endcomponent