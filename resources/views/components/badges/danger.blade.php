<span class="badge badge-danger{{ isset($pill) ? ' badge-pill' : '' }} {{ $class ?? '' }}"
      @if(isset($tooltip))
        data-toggle="tooltip" title="{{ $tooltip }}"
      @endif
>
    @if(isset($fa))
        <i class="fa fa-{{ $fa }} {{ $iconclass ?? '' }}"></i>
    @endif
    @isset($slot){{ $slot }}@endisset
</span>