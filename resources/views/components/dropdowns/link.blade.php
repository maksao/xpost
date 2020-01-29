{{--

    v.1.1

--}}
<a class="dropdown-item {{ $class ?? '' }}"
    href="{{ $url ?? '#'}}"
    @isset($target)
        target="{{ $target }}"
    @endisset
    @isset($attr)
        {!! \App\Helpers::array_to_attr_str($attr) !!}
    @endisset
    @isset($confirm)
        data-confirm="{{ $confirm }}"
    @endisset
>
    @isset($icon)
        <i class="fas {{ $icon }} fa-fw {{ isset($icon_class) ? $icon_class : '' }}"></i>
    @endisset
    @isset($title)
        <span class='title'>{{ $title }}</span>
    @endisset
    @isset($slot)
        {{ $slot }}
    @endisset
    @isset($help)
        <div class="dropdown-help">{!! $help !!}</div>
    @endisset
</a>
