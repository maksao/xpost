{{--

    v.1.0

--}}
<a class="dropdown-item danger" href="{{ $url ?? '' }}" data-action="delete-checked">
    Удалить отмеченные
    @isset($slot){{ $slot }}@endisset
    @if( isset($help) )
        <div class="dropdown-help">{{ $help }}</div>
    @endif
</a>
