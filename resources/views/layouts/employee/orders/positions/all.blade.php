@extends('layouts.app')

@section('content')

    @if( !$positions->count() )
        @include('components.messages.nothing_found')
    @else
        @component('components.tables.table',[
                'class' => 'small',
                'pagination'=>true,
                'items'=>$positions,
                'header' => [
                    'Заказ',
                    'Артикул',
                    'Производитель',
                    'Наименование',
                    'Кол-во' => ['align'=>'center'],
                    'Цена<br>поставщика' => ['align'=>'right'],
                    'Core' => ['align'=>'right'],
                    'Наценка(%)' => ['align'=>'right'],
                    'Цена<br>заказчка' => ['align'=>'right'],
                    'Сумма' => ['align'=>'right'],
                    'Внутренний номер заказа',
                    '<i class="fas fa-external-link-alt"></i>' => ['help'=>'Ссылка'],
                    'Статус' => ['align'=>'center'],
                    'Комментарий',
                    '#actions#'
                ]
            ])
            @foreach($positions as $position)
                @component('components.tables.row',['item'=>$position, 'theme'=>$position->status->theme])

                    {{-- Заказ --}}
                    <td>
                        <a href="{{ route('e.order.positions.index',$position->order_id) }}">{{ $position->order->number }}</a>
                        <div class="small">{{ $position->order->created_at->format('d.m.Y') }}</div>
                    </td>

                    {{-- Артикул --}}
                    <td>
                        @if( !$position->isProductOk() )
                            @include('components._project.icon_product_not_found')
                        @endif
                        {{ $position->article }}
                    </td>

                    {{-- Производитель --}}
                    <td>
                        @if(!$position->isBrandOk())
                            @include('components._project.icon_brand_not_found')
                            <span id="br{{ $position->id }}">{{ $position->brand_name }}</span>
                            @include('components.buttons.copy_to_cb',[ 'id'=>'br'.$position->id ])
                        @endif
                        {{ $position->brand_name }}
                    </td>

                    {{-- Название --}}
                    <td>
                        @component('components._project.product_names',['item'=>$position])@endcomponent
                    </td>

                    {{-- Количество --}}
                    <td class="text-center">
                        {{ $position->quantity }}
                    </td>

                    {{-- Цена поставщика --}}

                    @component('components.tables.cell_price',['price'=>$position->price])@endcomponent

                    {{-- Core --}}

                    <td class="text-right">
                        {{ $position->core }}
                    </td>

                    {{-- Наценка поставщика(%) --}}

                    <td class="text-right">
                        {{ $position->markup }}{{ $position->markup ? ' %' : '' }}
                    </td>

                    {{-- Цена заказчика --}}

                    @component('components.tables.cell_price',['price'=>$position->price_contractor])@endcomponent

                    {{-- Цена (сумма) --}}
                    <td class="text-right">
                        {{ \App\Helpers::number_format($position->price_sum) }}
                    </td>

                    {{-- Внутренний номер заказа --}}

                    <td>
                        {{ $position->inner_number }}
{{--                        @component('components.editable.editable', [--}}
{{--                            'ajax' => true,--}}
{{--                            'title' => 'Внутренний номер заказа',--}}
{{--                            'name' => 'inner_number',--}}
{{--                            'url' => route('c.order-positions.field.update', $position->id),--}}
{{--                            'id' => $position->id,--}}
{{--                        ]){{ $position->inner_number }}@endcomponent--}}
                    </td>

                    {{-- Ссылка на товар --}}

                    <td class="text-right">
                        @if($position->url)
                            <a href="{{ $position->url }}"><i class="fas fa-external-link-alt"></i></a>
                        @endif
                    </td>

                    {{-- Статус --}}
                    <td class="text-center">
                        {{ $position->status->name }}
                    </td>

                    {{-- комментарий --}}
                    <td>
                        {{ $position->comment }}
                    </td>

                    {{-- Действия --}}

                    <td class="text-right">
                        @component('components.dropdowns.actions',['item'=>$position])
                            {{--                        @can('update', $position)--}}
                            {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.order.positions.edit',[$order->id, $position->id])])--}}
                            {{--                        @endcan--}}
                            {{--                        @can('remove_paused_debt', $position)--}}
                            {{--                            @include('components.dropdowns.link', ['title' => 'Запустить в работу', 'url'=>route('contractor.order.positions.remove-paused-debt',[$order->id, $position->id])])--}}
                            {{--                        @endcan--}}
{{--                            @if($position->order->isStatus('prep'))--}}
{{--                                @include('components.dropdowns.link_delete', ['url'=>route('c.order.positions.destroy',[$position->order_id, $position->id])])--}}
{{--                            @endif--}}
                        @endcomponent
                    </td>
                @endcomponent
            @endforeach
        @endcomponent
    @endif

{{--    @push('scripts')--}}
{{--        <script src="/js/employee_order_positions.min.js"></script>--}}
{{--    @endpush--}}
@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.menu')
        @include('components.panels.menu.link_confirm', [
            'title'=>'Выгрузить для заказа',
            'url' => route('e.order-positions.export-for-order',Request::getQueryString()),
            'method' => 'get',
            'modal_body' => 'Все доступные позиции (с учетом фильтра) будут выгружены в Excel и их статус будет заменен на "' . \App\OrderPositionStatus::find(4)->name . '"'
        ])
    @endcomponent

    {{-- Информация --}}

{{--    @component('components.panels.info',['item'=>$order])--}}

{{--        @component('components.panels.info.badge', [--}}
{{--            'title'=>'Статус заказа',--}}
{{--            'badge'=>$order->status->name,--}}
{{--            'theme' => $order->status->theme,--}}
{{--            'align' => 'center'--}}
{{--        ])@endcomponent--}}

{{--        @component('components.panels.info.text', ['title'=>'Сумма заказа'])--}}
{{--            {{ \App\Helpers::price_format($order->getCost()) }}--}}
{{--        @endcomponent--}}

{{--    @endcomponent--}}

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Артикул','name'=>'article'])@endcomponent
    @endcomponent
@endsection
