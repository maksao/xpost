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
            'Цены в пр.л.' => ['align'=>'center', 'help'=>'Найдено цен в прайслистах'],
            ''
        ]
    ])
        @foreach($s_result as $product)
            @component('components.tables.row',['item'=>$product, 'class'=>'small'])

                {{-- Артикул --}}

                <td>
                    {{ $product->article }}
                </td>

                {{-- Бренд --}}

                <td>
                    @if($product->brand)
                        {{ $product->brand->name }}
                    @else
                        @include('components._project.icon_brand_not_found')
                    @endif
                </td>

                {{-- Название --}}

                <td>
                    @include('components._project.product_names',['item'=>$product])
                </td>

                {{-- Вес --}}

                @component('components.tables.cell_weight',['weight'=>$product->weight])@endcomponent

                {{-- Цена --}}

                @component('components.tables.cell_price',[
                    'price' => 0
                ])@endcomponent

                {{-- Core --}}

                @component('components.tables.cell_price',[
                    'price' => 0
                ])@endcomponent

                {{-- Цены в прайслистах --}}
                <td class="text-center">
                    @include('components.badges.count',['count'=>$product->prices_count])
                </td>

                {{-- Форма добавления в заказ--}}
                <td style="width: 200px">
                    @component('components.forms.form', ['url'=>route('c.order.products.add-from-products',[$order->id, $product->id]), 'method'=>'post', 'required_notice'=>false])
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
                </td>
            @endcomponent
        @endforeach
    @endcomponent
</div>
