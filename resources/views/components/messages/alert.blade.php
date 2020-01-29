{{--

    v.1.0

--}}
<div class="alert alert-{{ $bg_theme ?? $theme ?? 'secondary' }} border-{{ $border_theme ?? $theme ?? 'secondary' }} alert-dismissible">
    @isset($header)
        <h4 class="alert-heading">{{ $header }}</h4>
    @endisset
    {{ $slot }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
