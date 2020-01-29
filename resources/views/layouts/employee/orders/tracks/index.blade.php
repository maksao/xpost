@extends('layouts.app')

@section('content')

{{--    @include('layouts.contractor.orders.contractor_header')--}}

    @if( !$tracks->count() )

        @include('components.messages.nothing_found')

    @else

        @component('components.tables.table',[
            'header' => [
                '',
                'Номер',
                'Служба доставки по США',
                'Подтверждено продавцом',
                'Подтверждено покупателем',
                '#actions#'
            ]
        ])
            @foreach($tracks as $track)
                @component('components.tables.row',['item'=>$track])
                    {{-- Порядковый номер --}}
                    <td>
                        {{ $loop->index + 1 }}
                    </td>

                    {{-- Номер --}}
                    <td>
                        @component('components.editable.editable', [
                           'ajax' => true,
                           'title' => 'Номер трека',
                           'name' => 'number',
                           'url' => route('e.order-tracks.field.update', $track->id),
                           'id' => $track->id,
                       ]){{ $track->number }}@endcomponent
                    </td>

                    {{-- Служба доставки по США --}}
                    <td>
                       {{ $track->delivery_service->name }}
                    </td>

                    {{-- Подтверждено продавцом --}}
                    <td>
                        @if(!$track->e_received_at)
                            <i class="fas fa-minus-circle fa-fw text-danger"></i>
                            <button class="btn btn-xs btn-outline-primary" data-confirm="get" data-url="{{ route('e.order-tracks.e-confirm', $track->id) }}" data-text="Подтвердить получение?">
                                подтвердить
                            </button>
                        @else
                            <i class="fas fa-check-circle fa-fw text-success"></i>
                            <button class="btn btn-xs btn-outline-primary" data-confirm="get" data-url="{{ route('e.order-tracks.e-confirm', $track->id) }}" data-text="Отменить подтверждение получения?">
                                {{ $track->e_received_at->format('d.m.Y H:i') }}
                            </button>
                        @endif
                    </td>

                    {{-- Подтверждено покупателем --}}
                    <td>
                        @if($track->c_received_at)
                            <i class="fas fa-check-circle fa-fw text-success"></i> {{ $track->c_received_at->format('d.m.Y H:i') }}
                        @else
                            <i class="fas fa-minus-circle text-danger"></i>
                        @endif
                    </td>

                    {{-- Действия --}}

                    <td class="text-right">
                        @component('components.dropdowns.actions',['item'=>$track])
    {{--                        @can('update', $position)--}}
    {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.order.positions.edit',[$order->id, $position->id])])--}}
    {{--                        @endcan--}}
    {{--                        @can('remove_paused_debt', $position)--}}
    {{--                            @include('components.dropdowns.link', ['title' => 'Запустить в работу', 'url'=>route('contractor.order.positions.remove-paused-debt',[$order->id, $position->id])])--}}
    {{--                        @endcan--}}
                            @can('delete', $track)
                                @include('components.dropdowns.link_delete', ['url'=>route('e.order.tracks.destroy',[$order->id, $track->id])])
                            @endcan
                        @endcomponent
                    </td>
                @endcomponent
            @endforeach
        @endcomponent

    @endif

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.menu')
        @include('components.panels.menu.link', ['title'=>'Позиции заказа','url'=>route('e.order.positions.index', $order->id)] )
    @endcomponent

    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['title'=>'Добавить трек', 'mtitle'=>'Новый трек', 'url'=>route('e.order.tracks.store', $order->id)] )
            @slot('mFields')
                @component('components.forms.plain.select',['label'=>'Служба доставки', 'name'=>'delivery_service_id', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                    @foreach($delivery_services as $ds)
                        @include('components.forms.elements.option',['label'=>$ds->name, 'value'=>$ds->id])
                    @endforeach
                @endcomponent
                @include('components.forms.plain.input',['label'=>'Номер трека', 'name'=>'number', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @endslot
        @endcomponent
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Номер','name'=>'number'])@endcomponent
    @endcomponent

    {{-- Информация --}}

        @component('components.panels.info',['item'=>$order])

            @component('components.panels.info.text', ['title'=>'Номер заказа'])
                {{ $order->number }}
            @endcomponent
            @component('components.panels.info.text', ['title'=>'Контрагент'])
                {{ $order->user->name }}
            @endcomponent

        @endcomponent
@endsection
