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
            @foreach($positions as $key => $position)
                @component('components.tables.row',['item'=>$position, 'theme'=>$position->status->theme])
                    {{-- Порядковый номер --}}
                    <td>
                        {{ $key + 1 }}
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
                        @else
                            {{ $position->brand_name }}
                        @endif
                    </td>

                    {{-- Название --}}
                    <td>
                        @component('components._project.product_names',['item'=>$position])@endcomponent
                    </td>

                    {{-- Количество --}}
                    <td class="text-center">
                        @if($order->status_id == 1)
                            @component('components.editable.editable', [
                                'title' => 'Количество',
                                'type' => 'number',
                                'name' => 'quantity',
                                'url' => route('c.order-positions.field.update', $position->id),
                                'id' => $position->id,
                                'attr' => 'min=1'
                            ]){{ $position->quantity }}@endcomponent
                        @else
                            {{ $position->quantity }}
                        @endif
                    </td>

                    {{-- Цена поставщика --}}

                    @if($order->status_id == 1)
                        @component('components.tables.cell_price',[
                            'price'=>$position->price,
                            'editable' => [
                                'item' => $position,
                                'url' => route('c.order-positions.field.update', $position->id),
                            ]
                        ])@endcomponent
                    @else
                        @component('components.tables.cell_price',['price'=>$position->price])@endcomponent
                    @endif

                    {{-- Core --}}

                    <td class="text-right">
                        @if($order->status_id == 1)
                            @component('components.editable.editable', [
                                'title' => 'Core',
                                'name' => 'core',
                                'url' => route('c.order-positions.field.update', $position->id),
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
                        @component('components.editable.editable', [
                            'ajax' => true,
                            'title' => 'Внутренний номер заказа',
                            'name' => 'inner_number',
                            'url' => route('c.order-positions.field.update', $position->id),
                            'id' => $position->id,
                        ]){{ $position->inner_number }}@endcomponent
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
                           'url' => route('c.order-positions.field.update', $position->id),
                           'id' => $position->id,
                       ]){{ $position->comment }}@endcomponent
                    </td>

                    {{-- Действия --}}

                    <td class="text-right">
                        @component('components.dropdowns.actions',['item'=>$position])
    {{--                        @can('update', $position)--}}
    {{--                            @include('components.dropdowns.link_edit', ['url'=>route('contractor.order.positions.edit',[$order->id, $position->id])])--}}
    {{--                        @endcan--}}
                            @if(! $position->isProductOk() )
                                @include('components.dropdowns.link', ['title' => 'Добавить в справочники', 'url'=>route('c.order.positions.add-product',[$order->id, $position->id])])
                                @include('components.dropdowns.link', ['title' => 'Проверить позицию', 'url'=>route('c.orders.verify-positions',[$order->id, $position->id])])
                            @endif
                            @if($order->isStatus('prep'))
                                @include('components.dropdowns.link_delete', ['url'=>route('c.order.positions.destroy',[$order->id, $position->id])])
                            @endif
                        @endcomponent
                    </td>
                @endcomponent
            @endforeach
        @endcomponent
    @endif

    {{-- Загрузка из файла или поиск --}}

    @if($order->isStatus('prep'))

        <div class="d-flex justify-content-between">

            {{-- Поиск по прайсам --}}

            <div>
                <div class="d-flex justify-content-center">
                    <div class="card text-center">
                        <div class="card-header{{ request('s_type') == 'pl' ? ' bg-orange' : '' }}">
                            Поиск по прайслистам
                        </div>
                        <div class="card-body">
                            @component('components.forms.form', [
                                'method'=>'get',
                                'class'=>'form-inline',
                                'required_notice'=>false,
                            ])
                                @include('components.forms.plain.input',[
                                    'name' => 's_article',
                                    'required' => true,
                                    'value' => request('s_article') ?? '',
                                    'placeholder' => 'Минимум 3 символа',
                                ])
                                <input type="hidden" name="s_type" value="pl">
                                <button type="submit" class="btn btn-primary ml-2">Найти</button>
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>

            {{-- Поиск по товару --}}

            <div>
                <div class="d-flex justify-content-center">
                    <div class="card text-center">
                        <div class="card-header{{ request('s_type') == 'pr' ? ' bg-orange' : '' }}">
                            Поиск по товару
                        </div>
                        <div class="card-body">
                            @component('components.forms.form', [
                                'method'=>'get',
                                'class'=>'form-inline',
                                'required_notice'=>false,
                            ])
                                @include('components.forms.plain.input',[
                                    'name' => 's_article',
                                    'required' => true,
                                    'value' => request('s_article') ?? '',
                                    'placeholder' => 'Минимум 3 символа',
                                ])
                                <input type="hidden" name="s_type" value="pr">
                                <button type="submit" class="btn btn-primary ml-2">Найти</button>
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>

            {{-- Загрузка из файла --}}

            <div>

                <div class="d-flex justify-content-center">
                    <div class="card text-center">
                        <div class="card-header">
                            Загрузка заказа из Excel
                            <button class="btn btn-sm btn-link" data-toggle="modal" data-target="#upload-help">
                                [Помощь <i class="fas fa-question-circle"></i>]
                            </button>
                            @push('modals')
                                @component('components.dialogs.modal',['id' => 'upload-help'])
                                    @include('layouts.contractor.orders.positions.upload_help')
                                @endcomponent
                            @endpush
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                @component('components.forms.form', [
                                    'url'=>route('c.order.positions.upload', $order->id),
                                    'method'=>'post',
                                    'class'=>'form-inline',
                                    'required_notice'=>false,
                                    'files' => true
                                ])
                                    {{-- Файл для загрузки--}}
                                    @include('components.forms.plain.input',[
                                        'type' => 'file',
                                        'name' => 'userfile',
                                        'required' => true
                                    ])
                                    <button type="submit" class="btn btn-primary ml-2">Загрузить</button>
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>

                @if( session('upload_errors') )
                    <div class="card text-white bg-danger my-3">
                        <div class="card-header">При загрузке заказа обнаружены следующие ошибки:</div>
                        <div class="card-body">
                            @foreach(session('upload_errors') as $u_error)
                                <p class="card-text">{{ $u_error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Результат поиска по прайслистам (если был)--}}

        @isset($s_pricelists_result)
            @include('layouts.contractor.orders.search_by_pricelists_result',['s_result' => $s_pricelists_result])
        @endisset

        {{-- Результат поиска по товару (если был)--}}

        @isset($s_products_result)
            @include('layouts.contractor.orders.search_by_products_result',['s_result' => $s_products_result])
        @endisset

    @endif

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.menu')
        @if( $order->isStatus('prep') )
            @include('components.panels.menu.link_confirm', ['title'=>'Очистить заказ','url'=>route('c.orders.clear', $order->id)] )
        @else
            @include('components.panels.menu.link', ['title'=>'Треки заказа','url'=>route('c.order.tracks.index', $order->id)] )
        @endif
        @can('accept', $order)
            @include('components.panels.menu.link_confirm', ['title'=>'Подтвердить заказ','url'=>route('c.orders.accept', $order->id)] )
        @endcan
        @can('reject', $order)
            @include('components.panels.menu.link_confirm', ['title'=>'Отменить подтверждение','url'=>route('c.orders.reject', $order->id)] )
        @endcan
        @if($positions->where('product_id', null)->count())
            @include('components.panels.menu.link_confirm', ['title'=>'Проверить позиции','url'=>route('c.orders.verify-positions', $order->id)] )
        @endif
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

    {{--    @component('components.panels.filters',['id'=>true])--}}
    {{--        @component('components.panels.filters.input',['label'=>'Номер','name'=>'number'])@endcomponent--}}
    {{--    @endcomponent--}}
@endsection
