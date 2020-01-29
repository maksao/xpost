{{--

    v.1.3

--}}
<a class="list-group-item list-group-item-action{{ isset($class) ? ' '.$class : ''}}"
   href="{{ $url ?? '#' }}"
   data-confirm="{{ $method ?? 'post' }}"
   @if(isset($modal_body)) data-text="{{ $modal_body }}" @endif
>
    <div class="d-flex align-items-center">
        @isset($icon)
            <i class="{{ $icon }} mr-3"></i>
        @endisset
        <div>
            @isset($title){{ $title }}@endisset
            {{ $slot ?? '' }}
            @isset($help)
                <div class="text-help">{{ $help }}</div>
            @endisset
        </div>
    </div>
</a>
