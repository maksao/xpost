<div class="list-group-item {{ isset($class) ? ' '.$class : ''}} bg-{{ isset($bg) ? $bg : 'dark' }} text-{{ isset($color) ? $color : 'white' }} py-2">
    {{ $slot }}
</div>
