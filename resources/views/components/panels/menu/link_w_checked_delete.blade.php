{{--

    v.1.0

--}}
<a class="list-group-item list-group-item-action text-danger" href="{{ $url ?? '#' }}" data-action="delete-checked">
    <i class="far fa-check-square fa-fw text-sm"></i>&nbsp;
    {{ $title ?? 'Удалить' }}
    {{ $slot ?? '' }}
    @isset($help)
        <div class="text-help">{{ $help }}</div>
    @endisset
</a>
