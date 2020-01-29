@extends('layouts.app')

@section('content')
    @component('components.tables.table',[
        'pagination' => true,
        'items' => $prices,
        'header' => [
            'Артикул',
            'Бренд',
            'Название',
            'Цена' => ['align'=>'right'],
            'Core' => ['align'=>'right'],
            'Вес' => ['align'=>'right'],
            'Активно' => ['align'=>'right'],
            'Комментарий',
            '#actions#'
        ]
    ])
        @foreach($prices as $price)
            @component('components.tables.row',['item'=>$price, 'class'=>'small'])

                {{-- Артикул --}}
                <td>
                    @if( ! $price->isProductOk() )
                        <i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" title="Товар отсутствует в справочнике"></i>
                    @endif
                    {{ $price->article }}
                </td>

                {{-- Бренд --}}
                <td>
                    @if($price->isBrandOk())
                        {{ $price->brand_name }}
                    @else
                        <i class="fas fa-exclamation-circle text-danger" data-toggle="tooltip" title="Бренд отсутствует в справочнике"></i>
                        <span id="br{{ $price->id }}">{{ $price->brand_name }}</span>
                        @include('components.buttons.copy_to_cb',[ 'id'=>'br'.$price->id ])
                    @endif
                </td>

                {{-- Название --}}
                <td>
                    {{ $price->name }}
                </td>

                {{-- Цена --}}
                <td class="text-right">
                    {{ $price->price }}
                </td>

                {{-- Core --}}
                <td class="text-right">
                    {{ $price->core }}
                </td>

                {{-- Вес --}}
                <td class="text-right">
                    {{ $price->weight }}
                </td>

                {{-- Активно --}}
                <td class="text-right">
                    @include('components.forms.presets.switch',[
                        'id' => 'active'.$price->id,
                        'checked' => $price->is_active ? true : null,
                        'class' => 'mb-0',
                        'attr' => [
                            'data-url' => route('pricelist.prices.toggle-flag', [$price->id, 'active'])
                        ]
                    ])
                </td>

                {{-- Коментарий --}}
                <td>
                    @component('components.editable.editable', [
                       'ajax' => true,
                       'title' => 'Коментарий',
                       'name' => 'comment',
                       'url' => route('pricelist.prices.field.update', $price->id),
                       'id' => $price->id,
                   ]){{ $price->comment }}@endcomponent
                </td>

                {{-- Кнопки действий --}}
                @component('components.tables.cell_actions',['item'=>$price])
                    @if( $price->isBrandOk() && ! $price->isProductOk())
                        @include('components.dropdowns.link', [
                            'title' => 'Добавить в справочник',
                            'url' => route('products.store'),
                            'attr' => [
                                'data-toggle'=>'add-to-products',
                                'data-id' => $price->id
                            ]
                        ])
                    @endif
                    @if(1 > 1)
                        @include('components.dropdowns.link_delete', ['url' => route('brands.synonyms.destroy', [$brand->id, $synonym->id])])
                    @endcan
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent

    @push('modals')
        @component('components.dialogs.modal_w_form',[
            'id'  =>  'mProductCreate',
            'title' => 'Добавить в справочник товара',
            'url'       => route('products.store'),
        ])
            @include('components.forms.plain.input',['label'=>'Артикул', 'name'=>'article', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @component('components.forms.plain.select',['label'=>'Бренд', 'name'=>'brand_id', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                @foreach($brands as $brand)
                    @include('components.forms.elements.option',['label'=>$brand->name, 'value'=>$brand->id])
                @endforeach
            @endcomponent
            @include('components.forms.plain.input',['label'=>'Название (рус)', 'name'=>'name_rus', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Название (eng)', 'name'=>'name_eng', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Вес', 'name'=>'weight', 'value'=>'0.000', 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Ссылка', 'name'=>'url', 'value'=>'', 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.textarea',['label'=>'Примечание','name'=>'comment','errors'=>new \Illuminate\Support\MessageBag])
        @endcomponent
    @endpush

    @push('scripts')
        <script src="/js/e_prices.js"></script>
    @endpush
@endsection

{{-- Правое меню --}}

@section('r_side')

    @component('components.panels.toolbox')
        @include('components.panels.menu.link',['title'=>'Перепроверить бренды', 'url'=>route('pricelists.brands', $pricelist->id)])
        @include('components.panels.menu.link',['title'=>'Перепроверить товар', 'url'=>route('pricelists.products', $pricelist->id)])
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters')
        @component('components.panels.filters.input',['label'=>'Артикул','name'=>'article'])@endcomponent
        @component('components.panels.filters.input',['label'=>'Бренд','name'=>'brand'])@endcomponent
        @component('components.panels.filters.input',['label'=>'Название','name'=>'name'])@endcomponent
        @component('components.panels.filters.yes_no',['label'=>'Бренд подтвержден','name'=>'brand_id'])@endcomponent
        @component('components.panels.filters.yes_no',['label'=>'Товар подтвержден','name'=>'product_id'])@endcomponent
    @endcomponent

    {{-- Информация --}}

    @component('components.panels.info',['item'=>$pricelist])

        @component('components.panels.info.text', ['title'=>'Новые бренды'])
            <span class="text-pri font-weight-bold">{{ $nullBrandsCount }}</span>
        @endcomponent

        @component('components.panels.info.text', ['title'=>'Новый товар'])
            <span class="text-pri font-weight-bold">{{ $nullProductsCount }}</span>
        @endcomponent

    @endcomponent


    {{--    @include('spr.menu')--}}
@endsection
