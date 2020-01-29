<a class="dropdown-item" href="{{ $url ?? '' }}" data-action="with-checked">
    {{ $title ?? '' }}
    @if(isset($slot))
        {{ $slot }}
    @endif
    @if( isset($help) )
        <div class="dropdown-help">{{ $help }}</div>
    @endif
</a>
