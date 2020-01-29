{{--
    v.1.0
--}}
<td class="{{ $class ?? '' }}{{ $align ?? 'text-right' }}">
    @component('components.dropdowns.actions',get_defined_vars()['__data'])
        {{ $slot }}
    @endcomponent
</td>