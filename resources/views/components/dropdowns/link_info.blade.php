<a class="dropdown-item" href="{{ $url ?? '' }}" {{ isset($target) ? 'target='.$target : '' }}>
    <i class="fa fa-info fa-fw"></i> {{ $title ?? 'Информация' }}
    @if(isset($slot))
        {{ $slot }}
    @endif
</a>