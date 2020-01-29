{{--
    v.1.1
--}}
<tr class="{{ $class ?? '' }}
    @if(\App\Helpers::isHL($item->id))
        {{ ' table-primary' }}
    @elseif(isset($theme))
        {{ ' table-'.$theme }}
    @endif"
    @isset($id)
        id="{{ $id }}"
    @endisset
>
    {{ $slot }}
</tr>