{{--

    v.1.0

--}}
@isset($title)
    @component('components.panels.info.title'){{ $title }}@endcomponent
@endisset
<div class="card-text mb-3 px-3 py-1 bg-{{ isset($theme) ? $theme : 'gray-200' }} border rounded small {{ $class ?? '' }}">
    {{ $slot }}
</div>
