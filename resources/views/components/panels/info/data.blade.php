{{--

    v.1.0

--}}
<div class="card-text
        {{ isset($theme) ? ' bg-'.$theme : '' }}
        {{ isset($class) ? ' '.$class : '' }}
        {{ isset($slim) ? ' p-1' : '' }}
">
    {{ $slot ?? $text ?? '' }}
</div>
