<a href="{{ $url ?? '#' }}" class="list-group-item{{ isset($theme) ? ' list-group-item-'.$theme : '' }}{{ isset($class) ? ' '.$class : '' }} list-group-item-action d-flex justify-content-between align-items-center">
    <h6 class="mb-0">
        {{ $slot }}
        @isset($help)
            <div class="text-help">{{ $help }}</div>
        @endisset
    </h6>
    <div class="ml-3">
        @include('components.badges.count',['count'=>$count])
    </div>
</a>