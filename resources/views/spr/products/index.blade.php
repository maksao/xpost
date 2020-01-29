@extends('layouts.app')

@section('content')
    @component('components.tables.table', [
        'pagination' => true,
        'items' => $products,
        'header' => [
            'Артикул',
            'Производитель',
            'Название (рус)',
            'Название (eng)',
            'Вес',
            'Ссылка',
            'Примечание',
            '#actions#'
        ],
    ])
        @foreach($products as $product)
            @component('components.tables.row',['item'=>$product])

                {{-- Артикул --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Артикул',
                        'name' => 'article',
                        'url' => route('products.field.update', $product->id),
                        'id' => $product->id,
                    ]){{ $product->article }}@endcomponent
                </td>

                {{-- Произврлитель --}}

                <td>
                    {{ $product->brand->name }}
                </td>

                {{-- Название (рус) --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название (рус)',
                        'name' => 'name_rus',
                        'url' => route('products.field.update', $product->id),
                        'id' => $product->id,
                    ]){{ $product->name_rus }}@endcomponent
                </td>

                {{-- Название (eng) --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название (eng)',
                        'name' => 'name_eng',
                        'url' => route('products.field.update', $product->id),
                        'id' => $product->id,
                    ]){{ $product->name_eng }}@endcomponent
                </td>

                {{-- Вес --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Вес',
                        'name' => 'weight',
                        'url' => route('products.field.update', $product->id),
                        'id' => $product->id,
                    ]){{ $product->weight }}@endcomponent
                </td>

                {{-- Ссылка --}}

                <td>
                    @if($product->url)
                        <a href="{{ $product->url }}" target="_blank">Ссылка</a>
                    @endif
                </td>

                {{-- Примечание --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Примечание',
                        'name' => 'comment',
                        'url' => route('products.field.update', $product->id),
                        'id' => $product->id,
                    ]){{ $product->comment }}@endcomponent
                </td>

                @component('components.tables.cell_actions',['item'=>$product])
                    @include('components.dropdowns.link', [
                        'title' => 'Редактировать',
                        'url' => route('products.update', $product->id),
                        'attr' => [
                            'data-toggle'=>'m-update',
                            'data-id' => $product->id
                        ]
                    ])
                    @include('components.dropdowns.link_delete', ['url' => route('products.destroy', $product->id)])
                    @include('components.dropdowns.link_show_logs', ['params' => ['product', $product->id]])
                @endcomponent

            @endcomponent
        @endforeach
    @endcomponent

    @push('modals')
        @component('components.dialogs.modal_w_form',[
            'id'  =>  'mProductUpdate',
            'method' => 'put',
            'title' => 'Редактирование товара'
        ])
            @component('components.forms.horizontal.static_text',['label'=>'Артикул'])
                <span id="article"></span>
            @endcomponent
            @component('components.forms.horizontal.static_text',['label'=>'Бренд'])
                <span id="brand"></span>
            @endcomponent
            @include('components.forms.plain.input',['label'=>'Название (рус)', 'name'=>'name_rus', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Название (eng)', 'name'=>'name_eng', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Вес', 'name'=>'weight', 'value'=>'0.000', 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.input',['label'=>'Ссылка', 'name'=>'url', 'value'=>'', 'errors'=>new \Illuminate\Support\MessageBag])
            @include('components.forms.plain.textarea',['label'=>'Примечание','name'=>'comment','errors'=>new \Illuminate\Support\MessageBag])
        @endcomponent
    @endpush

    @push('scripts')
        <script src="/js/products.js"></script>
    @endpush

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox',['help_template'=>'spr.products.upload_help'])
        @component('components.panels.menu.button_modal_create', ['title'=>'Новый товар', 'url'=>route('products.store')] ) )
            @slot('mFields')
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
            @endslot
        @endcomponent
        @component('components.panels.menu.button_modal_file_upload',['title'=>'Загрузить из файла', 'url'=>route('products.upload')])@endcomponent
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Артикул','name'=>'article'])@endcomponent
        @component('components.panels.filters.input',['label'=>'Название','name'=>'name'])@endcomponent
        @component('components.panels.filters.select',['label'=>'Бренд', 'name'=>'brand'])
            @foreach($brands as $brand)
                @if($brand->products_count)
                    @include('components.forms.elements.option',[
                        'label'=>$brand->name,
                        'value'=>$brand->id,
                        'selected'=>request('brand') == $brand->id ? true : null
                    ])
                @endif
            @endforeach
        @endcomponent

    @endcomponent
{{--    @include('spr.menu',['active_code'=>'brands'])--}}
@endsection
