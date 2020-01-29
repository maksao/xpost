{{--
    Ячейка с чекбоксом для выделения позиции
    v.1.0
--}}
<td class="{{ $class ?? '' }}">
    @include('components.forms.elements.checkbox',[
        'id'    => 'id'.$value,
        'name'  => 'ids[]',
        'form'  => 'checked-actions-form',
        'value' => $value,
        'attr'  => isset($attr) && is_array($attr) ? array_add($attr, 'data-action', 'check-row' ) : ['data-action' => 'check-row']
    ])
</td>