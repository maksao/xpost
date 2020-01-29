{{--

    v.1.0

--}}
<a class="list-group-item list-group-item-action{{ isset($active) && $active ? ' bg-light text-primary' : ''}}{{ isset($class) ? ' '.$class : ''}}"
   href="{{ $url ?? '#' }}"
   data-action="with-checked"
>
    <i class="far fa-check-square fa-fw text-help"></i>&nbsp;
    @isset($title){{ $title }}@endisset
    @isset($slot){{ $slot }}@endisset
    @isset($help)
        <div class="text-help">{{ $help }}</div>
    @endisset
</a>
