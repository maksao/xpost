{{--
    v.1.2
--}}
<td class="text-nowrap text-{{ $align ?? 'right' }}">
    @isset($editable)
        @component('components.editable.editable', [
            'ajax' => $editable['ajax'] ?? null,
            'type' => 'price',
            'title' => 'Цена',
            'name' => $editable['name'] ?? 'price',
            'url' => $editable['url'] ?? '#',
            'id' => $editable['item']->id,
        ]){{ $price }}@endcomponent
    @else
        {{ \App\Helpers::price_format($price) }}
    @endisset
    {{ $currency ?? '' }}
</td>
