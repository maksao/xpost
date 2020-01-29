<a class="dropdown-item" href="{{ $url ?? '' }}" {{ isset($target) ? 'target='.$target : '' }}>
    @isset($icon)
        <i class="fas fa-edit fa-fw"></i>
    @endisset
    <span class="title">{{ $title ?? 'Редактировать' }}</span>
    @if(isset($slot))
        {{ $slot }}
    @endif
</a>