@extends('layouts.app')

@section('content')
    @component('components.tables.table',[
            'class' => 'small',
            'header' => [
                'Номер',
                'Дата',
                'Заказы',
                'Сумма' => ['align'=>'right'],
                '#actions#'
            ]
        ])
        @foreach($invoices as $invoice)
            <tr class="{{ \App\Helpers::isHL($invoice->id) ? ' hl-info' : '' }}">

                {{-- Номер --}}
                <td>
                    {{ $invoice->number }}
                </td>

                {{-- Дата создания --}}
                <td>
                    {{ $invoice->created_at->format('d.m.Y H:i') }}
                </td>

                {{-- Заказы --}}
                <td>
                    @include('components.badges.count_with_link', ['count'=>$invoice->orders_count, 'url'=>route('e.invoices.show', $invoice->id)])
                </td>

                {{-- Сумма --}}
                <td class="text-right">
                    {{ \App\Helpers::price_format($invoice->price) }}
                </td>

                {{-- Действия --}}

                @component('components.tables.cell_actions',['item'=>$invoice, 'theme'=>$invoice->theme == 'light' ? 'dark' : $invoice->theme])
                    {{--                        @can('confirm', $invoice)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['title'=>'Подтвердить заказ', 'url'=>route('contractor.orders.confirm',$invoice->id)])--}}
                    {{--                        @endif--}}
                    {{--                        @can('cancel', $invoice)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['title'=>'Отменить подтверждение', 'url'=>route('contractor.orders.cancel',$invoice->id)])--}}
                    {{--                        @endif--}}
                    {{--                        @can('update', $invoice)--}}
                    {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.orders.edit',$invoice->id)])--}}
                    {{--                        @endcan--}}
                    @can('delete', $invoice)
                        @include('components.dropdowns.link_delete', ['url'=>route('c.orders.destroy',$invoice->id)])
                    @endcan
                    @include('components.dropdowns.link_show_logs', ['params' => ['invoice', $invoice->id]])
                @endcomponent
            </tr>
        @endforeach

    @endcomponent
@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['title'=>'Создать инвойс', 'url'=>route('e.invoices.store')] ) )
        @slot('mFields')
            @include('components.forms.plain.input',['label'=>'Номер инвойса', 'name'=>'number', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            {{-- Тип доставки --}}
{{--            @component('components.forms.plain.select', ['label'=>'Тип доставки', 'name'=>'delivery_type_id', 'required'=>true])--}}
{{--                @foreach($delivery_types as $delivery_type)--}}
{{--                    @component('components.forms.elements.option',[--}}
{{--                        'label' => $delivery_type->name,--}}
{{--                        'value' => $delivery_type->id,--}}
{{--                    ])@endcomponent--}}
{{--                @endforeach--}}
{{--            @endcomponent--}}
        @endslot
        @endcomponent
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Номер','name'=>'number'])@endcomponent
    @endcomponent
    {{--    @include('spr.menu',['active_code'=>'brands'])--}}
@endsection
