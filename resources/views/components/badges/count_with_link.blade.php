{{--
    Счетчик со ссылкой
    v.1.1
--}}
<a href="{{ $url ?? '#' }}" class="btn btn-outline-{{ $count ? ( $theme ?? 'primary') : 'secondary' }} btn-{{ $size ?? 'xs' }}">
    <i class="fa fa-folder{{ $count ? '-open' : '' }} fa-fw"></i>
    <span class="badge badge-light"
        @if(isset($tooltip))
            data-toggle="tooltip" title="{{ $tooltip }}"
        @endif
    >{{ $count }}</span>
</a>
