{{--
    Счетчик
    v.1.1
--}}
<span class="badge badge-{{ $count ? $theme ?? 'success' : 'light' }} badge-pill badge-{{ $size ?? 'xs'}}{{ isset($class) ? ' '.$class : '' }}"
    @if(isset($tooltip))
        data-toggle="tooltip" title="{{ $tooltip }}"
    @endif
>{{ $count }}</span>
