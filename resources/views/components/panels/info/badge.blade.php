{{--

    v.1.1

--}}
@isset($title)
    @component('components.panels.info.title'){{ $title }}@endcomponent
@endisset
<div class="card-text mb-3 px-3 text-{{ $align ?? 'right' }} bg-gray-200 border rounded">
    <span class="badge {{ isset($pill) ? 'badge-pill' : '' }} badge-{{ isset($theme) ? $theme : 'dark' }}">{{ $badge }}</span>
</div>

