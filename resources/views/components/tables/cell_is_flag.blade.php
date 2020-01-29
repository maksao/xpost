{{--
    v.1.0
--}}
<td class="{{ $td_class ?? '' }}">
    @if($item->isFlag($flag))
        <i class="far fa-check-circle text-primary" @if(isset($title)) data-toggle="tooltip" title="{{ $title }}" @endif></i>
    @else
        @if( isset($shownot) )
            <i class="far fa-times-circle text-danger" @if(isset($titlenot)) data-toggle="tooltip" title="{{ $titlenot }}" @endif></i>
        @endif
    @endif
</td>
