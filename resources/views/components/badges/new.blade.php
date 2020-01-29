<span class="badge badge-danger">
    @if(isset($fa))
        <i class="fa fa-{{ $fa }} fa-fw"></i>
    @endif
    {{ $title ?? 'Новая' }}
</span>