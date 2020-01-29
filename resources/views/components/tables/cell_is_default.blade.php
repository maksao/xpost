{{--
    v.1.2
--}}
<td class="{{ $td_class ?? '' }}">
    @if($item->isDefault())
        @include('components._project.icons.spr_default', ['title' => $title ?? null])
    @endif
</td>
