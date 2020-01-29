@extends('layouts.app')

@section('content')
{{--    <h4>--}}
{{--        Статус заказа: <span class="badge badge-{{ $order->statusTheme() }}">{{ $order->status->name }}</span>--}}
{{--        @can('confirm', $order)--}}
{{--            <a href="{{ route('contractor.orders.confirm', $order->id) }}" class="btn btn-success btn-xs">Подтвердить заказ</a>--}}
{{--        @endif--}}
{{--        @can('cancel', $order)--}}
{{--            <a href="{{ route('contractor.orders.cancel', $order->id) }}" class="btn btn-danger btn-xs">Отменить подтверждение заказа</a>--}}
{{--        @endif--}}
{{--    </h4>--}}

    @include('layouts.contractor.orders.contractor_header')

    @if( !$positions->count() )
        @include('components.messages.nothing_found')
    @else
        @component('components.tables.table',[
            'class' => 'small',
            'header' => [
                '',
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
                'Ссылка',
                'Статус' => ['align'=>'center'],
                'Комментарий',
                '#actions#'
            ]
        ])
            @foreach($positions as $position)
                @component('components.tables.row',['item'=>$position, 'theme'=>$position->status->theme])
                    {{-- Порядковый номер --}}
                    <td>
                        {{ $loop->index + 1 }}
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

                    @if($order->status_id == 2)
                        @component('components.tables.cell_price',[
                            'price'=>$position->price,
                            'editable' => [
                                'item' => $position,
                                'url' => route('e.order-positions.field.update', $position->id),
                            ]
                        ])@endcomponent
                    @else
                        @component('components.tables.cell_price',['price'=>$position->price])@endcomponent
                    @endif

                    {{-- Core --}}

                    <td class="text-right">
                        @if($order->status_id == 2)
                            @component('components.editable.editable', [
                                'title' => 'Core',
                                'name' => 'core',
                                'url' => route('e.order-positions.field.update', $position->id),
                                'id' => $position->id,
                            ]){{ $position->core }}@endcomponent
                        @else
                            {{ $position->core }}
                        @endif
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
                            <a href="{{ $position->url }}">ссылка</a>
                        @endif
                    </td>

                    {{-- Статус --}}

                    <td class="text-center">
                        {{ $position->status->name }}
                    </td>

                    {{-- комментарий --}}

                    <td>
                        @component('components.editable.editable', [
                           'ajax' => true,
                           'title' => 'Коментарий',
                           'name' => 'comment',
                           'url' => route('e.order-positions.field.update', $position->id),
                           'id' => $position->id,
                       ]){{ $position->comment }}@endcomponent
                    </td>

                    {{-- Действия --}}

                    <td class="text-right">
                        @component('components.dropdowns.actions',['item'=>$position])
                            @if($position->quantity > 1)
                                @include('components.dropdowns.link_modal_form', [
                                    'id' => 'mSplit',
                                    'title'=>'Разделить',
                                    'url'=>route('e.order-positions.split',$position->id)
                                ])
                            @endif
                            {{--                        @can('update', $position)--}}
                            {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.order.positions.edit',[$order->id, $position->id])])--}}
                            {{--                        @endcan--}}
                            {{--                        @can('remove_paused_debt', $position)--}}
                            {{--                            @include('components.dropdowns.link', ['title' => 'Запустить в работу', 'url'=>route('contractor.order.positions.remove-paused-debt',[$order->id, $position->id])])--}}
                            {{--                        @endcan--}}
{{--                            @if($order->isStatus('prep'))--}}
{{--                                @include('components.dropdowns.link_delete', ['url'=>route('c.order.positions.destroy',[$order->id, $position->id])])--}}
{{--                            @endif--}}
                        @endcomponent
                    </td>
                @endcomponent
            @endforeach
        @endcomponent
    @endif

{{--    Окно с формой для разделения позиции --}}

    @push('modals')
        @component('components.dialogs.modal_w_form',['id'=>'mSplit', 'title'=>'Разделение позиции'])
            <p>Укажите, какое количество Вы хотите отделить в другую позицию</p>
            @include('components.forms.elements.input',[
                'type' => 'number',
                'name' => 'qtty',
                'value' => 1,
                'attr' => ['min'=>1]
            ])
        @endcomponent
    @endpush
@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.menu')
        @include('components.panels.menu.link', ['title'=>'Треки заказа','url'=>route('e.order.tracks.index', $order->id)] )
        @include('components.panels.menu.link_confirm', [
            'title'=>'Выгрузить для заказа',
            'url' => route('e.order-positions.export-for-order',Request::getQueryString().'&order_id='.$order->id),
            'method' => 'get',
            'modal_body' => 'Все доступные позиции (с учетом фильтра) будут выгружены в Excel и их статус будет заменен на "' . \App\OrderPositionStatus::find(4)->name . '"'
        ])
    @endcomponent

    {{-- Информация --}}

    @component('components.panels.info',['item'=>$order])

        @component('components.panels.info.badge', [
            'title'=>'Статус заказа',
            'badge'=>$order->status->name,
            'theme' => $order->status->theme,
            'align' => 'center'
        ])@endcomponent

        @component('components.panels.info.text', ['title'=>'Сумма заказа'])
            {{ \App\Helpers::price_format($order->price) }}
        @endcomponent
        @component('components.panels.info.text', ['title'=>'Доставка'])
            {{ \App\Helpers::price_format($order->delivery_cost) }}
        @endcomponent
        @component('components.panels.info.text', ['title'=>'Сумма заказа с доставкой'])
            {{ \App\Helpers::price_format($order->price_D) }}
        @endcomponent

    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Артикул','name'=>'article'])@endcomponent
    @endcomponent
@endsection
