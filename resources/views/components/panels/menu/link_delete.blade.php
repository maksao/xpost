{{--

    v.1.1

--}}
<a class="list-group-item list-group-item-action text-danger" href="{{ $url ?? '#' }}" data-toggle="confirm-delete">
    @isset($title){{ $title }}@endisset
    {{ $slot ?? '' }}
    @isset($help)
        <div class="text-help">{{ $help }}</div>
    @endisset
</a>
