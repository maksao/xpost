<div class="mt-4">
    @unless($s_result->count())
        @component('components.messages.alert',['theme'=>'info'])
            По Вашему запросу ничего не найдено
        @endcomponent
    @endunless
    @component('components.tables.table',[
        'header' => [
            'Артикул',
            'Бренд',
            'Название',
            'Вес' => ['align'=>'right'],
            'Цена' => ['align'=>'right'],
            'Core' => ['align'=>'right'],
            'Прайслист',
            ''
        ]
    ])
        @foreach($s_result as $price_position)
            @component('components.tables.row',['item'=>$price_position, 'class'=>'small'])

                {{-- Артикул --}}

                <td>
                    @if(!$price_position->isProductOk())
                        @include('components._project.icon_product_not_found')
                    @endif
                    {{ $price_position->article }}
                </td>

                {{-- Бренд --}}

                <td>
                    @if($price_position->isBrandOk())
                        {{ $price_position->brand->name }}
                    @else
                        @include('components._project.icon_brand_not_found')
                        {{ $price_position->brand_name }}
                    @endif
                </td>

                {{-- Название --}}

                <td>
                    @include('components._project.product_name',[
                        'lang'=>'рус',
                        'name'=>$price_position->product ? $price_position->product->name_rus : 'нет'
                    ])
                    @include('components._project.product_name',[
                        'lang'=>'eng',
                        'name'=>$price_position->product ? $price_position->product->name_eng : $price_position->name
                    ])
                </td>

                {{-- Вес --}}

                @component('components.tables.cell_weight',['weight'=>$price_position->weight])@endcomponent

                {{-- Цена --}}

                @component('components.tables.cell_price',['price'=>$price_position->price])@endcomponent

                {{-- Core --}}

                @component('components.tables.cell_price',['price'=>$price_position->core])@endcomponent

                {{-- Название прайслиста --}}

                <td>
                    {{ $price_position->pricelist->name }}
                </td>

                {{-- Форма добавления в заказ--}}
                <td style="width: 200px">
                    @if($price_position->isBrandOk() && $price_position->isProductOk())
                        @component('components.forms.form', ['url'=>route('c.order.products.add-from-pricelist',[$order->id, $price_position->id]), 'method'=>'post', 'required_notice'=>false])
                            @component('components.forms.horizontal.input_group_btn',[
                                'type' => 'number',
                                'name' => 'quantity',
                                'required' => true,
                                'value' => 1,
                                'attr' => ['min'=>1, 'size'=>'3'],
                                'class' => 'form-control-xs',
                                'form_group_class' => 'mb-0'
                            ])
                                @slot('append')
                                    <button type="submit" class="btn btn-primary form-control-xs">B заказ</button>
                                @endslot
                            @endcomponent
                        @endcomponent
                    @else
                        <a href="{{ route('pricelists.show',[$price_position->pricelist_id, 'article'=>$price_position->article]) }}">Поправить</a>
                    @endif
                </td>
            @endcomponent
        @endforeach
    @endcomponent
</div>
