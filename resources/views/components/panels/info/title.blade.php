{{--

    v.1.1

--}}
<div class="card-text small font-weight-600
    {{ $margin ?? ' mb-2' }}
    {{ isset($theme) ? ' bg-'.$theme : '' }}
    {{ $class ?? '' }}
">
    {{ $slot ?? $text ?? '' }}
</div>
