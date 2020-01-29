{{--
    Ячейка с позицией записи
    v.1.1
--}}
<td class="{{ $class ?? '' }}">
    @if( !isset($update) || $update === true )
        @component('components.editable.editable', [
            'type' => 'number',
            'title' => 'Позиция',
            'name' => 'pos',
            'url' => route($pos_route_prefix.'.field.update', $item->id),
            'id' => $item->id,
            'attr' => 'min=1'
        ]){{ $item->pos }}@endcomponent
    @else
        {{ $item->pos }}
    @endif
</td>