{{--

    v.1.1

--}}
@if(isset($active) && $active)
    <div class="list-group-item bg-light text-primary font-weight-600{{ isset($class) ? ' '.$class : ''}}" href="{{ $url ?? '#' }}"
        @isset($attr)
            {!! \App\Helpers::array_to_attr_str($attr) !!}
        @endisset
    >
        @isset($icon)<i class="{{ $icon }} fa-fw"></i> @endisset
        @isset($title){{ $title }}@endisset
        @isset($slot){{ $slot }}@endisset
        @isset($help)
            <div class="text-help">{{ $help }}</div>
        @endisset
    </div>
@else
    <a class="list-group-item list-group-item-action{{ isset($class) ? ' '.$class : ''}}" href="{{ $url ?? '#' }}"
        @isset($attr)
            {!! \App\Helpers::array_to_attr_str($attr) !!}
        @endisset
    >
        @isset($icon)<i class="{{ $icon }} fa-fw"></i> @endisset
        @isset($title){{ $title }}@endisset
        @isset($slot){{ $slot }}@endisset
        @isset($help)
            <div class="text-help">{{ $help }}</div>
        @endisset
    </a>
@endif