{{--

    v.1.0

--}}
<div class="list-group {{ $margin ?? 'mb-2' }} {{ $class ?? '' }}">
    <div class="list-group-item bg-{{ $theme ?? 'primary' }} text-{{ $color ?? 'white' }} clickable" data-toggle="collapse" data-target="#panel-menu-{{ $id ?? 'default' }}">
        <h6 class="mb-0"><i class="fas fa-{{ $icon ?? 'bars' }} fa-fw"></i> {{ $header ?? 'Меню' }}</h6>
    </div>
    <div class="collapse{{ isset($hide) ? '' : ' show' }}" id="panel-menu-{{ $id ?? 'default' }}">
        {{ $slot }}
    </div>
</div>
