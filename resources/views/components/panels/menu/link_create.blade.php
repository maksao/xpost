{{--

    v.1.0

--}}
<a class="list-group-item list-group-item-action{{ isset($active) && $active ? ' bg-light text-primary' : ''}}{{ isset($class) ? ' '.$class : ''}}" href="{{ $url ?? '#' }}">
    <i class="fas fa-plus-square fa-fw text-success"></i> {{ $title ?? 'Добавить запись' }}
    @isset($help)
        <div class="text-help">{{ $help }}</div>
    @endisset
</a>
