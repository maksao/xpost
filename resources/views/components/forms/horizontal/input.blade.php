{{--

    v.1.0

--}}
@component( 'components.forms.horizontal.wrapper', get_defined_vars()['__data'] )
    @if(isset($type) && $type == 'file')
        @include('components.forms.elements.file_browser')
    @else
        @include('components.forms.elements.input')
    @endif
@endcomponent
