<span class="badge badge-{{ $color ?? 'secondary' }}{{ isset($pill) ? ' badge-pill' : '' }}{{ isset($class) ? ' '.$class : '' }}"
        @if(isset($tooltip))
            data-toggle="tooltip" title="{{ $tooltip }}"
        @endif
>
    @if(isset($fa))
        <i class="fa fa-{{ $fa }} fa-fw"></i>
    @endif
    {{ $title ?? '' }}{{ $label ?? '' }}
</span>