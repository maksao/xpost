<a href="{{ $url ?? '#' }}"
   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center{{ isset($class) ? ' '.$class : ''}}{{ isset($active) ? ' list-group-item-success' : ''}}"
>
    {{ $slot }}
    @include('components.badges.count', ['count'=>$count])
</a>
