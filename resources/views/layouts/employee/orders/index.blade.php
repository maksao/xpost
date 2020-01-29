@extends('layouts.app')

@section('content')
    @component('components.tables.table',[
        'class' => 'small',
        'header' => [
            'Дата',
            'Номер',
            'Доставка',
            'Позиции',
            'Треки',
            'Статус',
            'Доставка' => ['align'=>'right'],

            'СЗП'=>['align'=>'right','help'=>'Стоимость заказа поставщика'],
            'СЗПсД'=>['align'=>'right','help'=>'Стоимость заказа поставщика с доставкой'],

            'Стоимость' => ['align'=>'right', 'help'=>'Чистая стоимость заказа'],
            'СЗсД' => ['align'=>'right','help'=>'Стоимость заказа с доставкой'],

            'Контрагент',
            'Инвойс',
            'Комментарий',
            '#actions#'
        ]
    ])
        @foreach($orders as $order)
            <tr class="table-{{ $order->theme }}{{ \App\Helpers::isHL($order->id) ? ' hl-info' : '' }}">

                {{-- Дата создания --}}
                <td>
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </td>

                {{-- Номер --}}
                <td>
                    {{ $order->number }}
                </td>

                {{-- Доставка --}}
                <td>
                    {{ $order->delivery_type->name }}
                </td>

                {{-- Позиции --}}
                <td>
                    @include('components.badges.count_with_link', ['count'=>$order->positions_count, 'url'=>route('e.order.positions.index', $order->id)])
                </td>

                {{-- Треки --}}
                <td>
                    @include('components.badges.count_with_link', ['count'=>$order->tracks_count, 'url'=>route('e.order.tracks.index', $order->id)])
                </td>

                {{-- Статус --}}
                <td>
                    {{ $order->status->name }}
                </td>

                {{-- Стоимость доставки заказа --}}
                <td class="text-right">
                    @component('components.editable.editable', [
                        'type' => 'price',
                        'title' => 'Стоимость доставки заказа',
                        'name' => 'delivery_cost',
                        'url' => route('e.orders.field.update', $order->id),
                        'id' => $order->id,
                    ]){{ $order->delivery_cost }}@endcomponent
                </td>

                {{-- СЗП - Стоимость заказа поставщика --}}
                <td class="text-right border-left border-primary border-top-0">
                    {{ \App\Helpers::price_format($order->price_SZP) }}
                </td>

                {{-- СЗПсД - Стоимость заказа поставщика с доставкой --}}
                <td class="text-right border-right border-primary border-top-0">
                    {{ \App\Helpers::price_format($order->price_SZP_D) }}
                </td>

                {{-- Стоимость --}}
                <td class="text-right">
                    {{ \App\Helpers::price_format($order->price) }}
                </td>

                {{-- Стоимость заказа с доставкой --}}
                <td class="text-right">
                    {{ \App\Helpers::price_format($order->price_D)  }}
                </td>

                {{-- Контрагент --}}
                <td>
                    {{ $order->user->name }}
                </td>

                {{-- Инвойс --}}
                <td>
                    {{ $order->invoice ? $order->invoice->number : '-' }}
                </td>

                {{-- Комментарий --}}
                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Комментарий',
                        'name' => 'comment',
                        'url' => route('e.orders.field.update', $order->id),
                        'id' => $order->id,
                    ]){{ $order->comment }}@endcomponent
                </td>

                {{-- Действия --}}

                @component('components.tables.cell_actions',['item'=>$order, 'theme'=>$order->theme == 'light' ? 'dark' : $order->theme])
                    {{--                        @can('confirm', $order)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['title'=>'Подтвердить заказ', 'url'=>route('contractor.orders.confirm',$order->id)])--}}
                    {{--                        @endif--}}
                    {{--                        @can('cancel', $order)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['title'=>'Отменить подтверждение', 'url'=>route('contractor.orders.cancel',$order->id)])--}}
                    {{--                        @endif--}}
                    {{--                        @can('update', $order)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.orders.edit',$order->id)])--}}
                    {{--                        @endcan--}}
                    @can('delete', $order)
                        @include('components.dropdowns.link_delete', ['url'=>route('c.orders.destroy',$order->id)])
                    @endcan
                @endcomponent
            </tr>
        @endforeach

    @endcomponent

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
{{--        @component('components.panels.menu.button_modal_create', ['url'=>route('c.orders.store')] ) )--}}
{{--        @slot('mFields')--}}
{{--            @include('components.forms.plain.input',['label'=>'Номер заказа', 'name'=>'number', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])--}}
{{--            --}}{{-- Тип доставки --}}
{{--            @component('components.forms.plain.select', ['label'=>'Тип доставки', 'name'=>'delivery_type_id', 'required'=>true])--}}
{{--                @foreach($delivery_types as $delivery_type)--}}
{{--                    @component('components.forms.elements.option',[--}}
{{--                        'label' => $delivery_type->name,--}}
{{--                        'value' => $delivery_type->id,--}}
{{--                    ])@endcomponent--}}
{{--                @endforeach--}}
{{--            @endcomponent--}}
{{--        @endslot--}}
{{--        @endcomponent--}}
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Номер','name'=>'number'])@endcomponent
    @endcomponent
    {{--    @include('spr.menu',['active_code'=>'brands'])--}}
@endsection
