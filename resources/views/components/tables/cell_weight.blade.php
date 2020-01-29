{{--
    v.1.0
--}}
<td class="text-nowrap text-{{ $align ?? 'right' }}">
    @isset($editable)
        @component('components.editable.editable', [
            'ajax' => $editable['ajax'] ?? null,
            'type' => '',
            'title' => 'Вес',
            'name' => $editable['name'] ?? 'weight',
            'url' => $editable['url'] ?? '#',
            'id' => $editable['item']->id,
        ]){{ $weight }}@endcomponent
    @else
        {{ \App\Helpers::weight_format($weight) }}
    @endisset
</td>
