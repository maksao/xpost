@extends('layouts.app')

@section('content')

    {{-- Если бренда нет в базе --}}
    @if( ! $position->isBrandOk() )
        <h3>Создать новый бренд или синоним</h3>
        @component('components.forms.form', ['url'=>route('c.order-positions.store-brand', $position->id),'id'=>'form', 'method'=>'post'])
            {{-- наименование --}}
            @component('components.forms.plain.input', [
                'label'=>'Название',
                'name'=>'name',
                'value' => $position->brand_name,
                'required'=>true,
            ])@endcomponent

            {{-- Синоним этого бренда --}}
            @component('components.forms.plain.select', [
                'label'=>'Синоним этого бренда',
                'name'=>'parent_id',
                'required'=>true,
            ])
                @include('components.forms.elements.option',[
                    'label' =>  '-- не синоним --',
                    'value' =>  0,
                ])
                @foreach($brands as $brand)
                    @include('components.forms.elements.option',[
                        'label' =>  $brand->name,
                        'value' =>  $brand->id,
                    ])
                @endforeach
            @endcomponent
        @endcomponent
    @else
        <h3>Создать новый товар</h3>
        @component('components.forms.form', ['url'=>route('c.order-positions.store-product', $position->id),'id'=>'form', 'method'=>'post'])

            @include('components.forms.horizontal.input',[
                'label'=>'Артикул',
                'name'=>'article',
                'value'=>$position->article,
                'readonly' => true,
            ])
            @include('components.forms.horizontal.input',[
                'label'=>'Бренд',
                'name'=>'brand_name',
                'value'=>$position->brand_name,
                'readonly' => true,
            ])
            <input type="hidden" name="brand_id" value="{{ $position->brand_id }}">

            @include('components.forms.horizontal.input',[
                'label'=>'Название (рус)',
                'name'=>'name_rus',
                'value'=>$position->name_rus,
                'required'=>true
            ])
            @include('components.forms.horizontal.input',[
                'label'=>'Название (eng)',
                'name'=>'name_eng',
                'value'=>$position->name_eng,
                'required'=>true
            ])
            @include('components.forms.horizontal.input',['label'=>'Вес', 'name'=>'weight', 'value'=>'0.000'])
            @include('components.forms.horizontal.input',['label'=>'Ссылка', 'name'=>'url', 'value'=>''])
            @include('components.forms.horizontal.textarea',['label'=>'Примечание','name'=>'comment'])

        @endcomponent
    @endif


@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.menu')
        @include('components.panels.menu.button_submit')
{{--        @can('accept', $order)--}}
{{--            @include('components.panels.menu.link_confirm', ['title'=>'Подтвердить заказ','url'=>route('c.orders.accept', $order->id)] )--}}
{{--        @endcan--}}
{{--        @can('reject', $order)--}}
{{--            @include('components.panels.menu.link_confirm', ['title'=>'Отменить подтверждение','url'=>route('c.orders.reject', $order->id)] )--}}
{{--        @endcan--}}
    @endcomponent

    {{-- Информация --}}

    @component('components.panels.info',['item'=>$position])

{{--        @component('components.panels.info.text', ['title'=>'Сумма заказа'])--}}
{{--            {{ \App\Helpers::price_format($order->getCost()) }}--}}
{{--        @endcomponent--}}

    @endcomponent

    {{-- Фильтры --}}

    {{--    @component('components.panels.filters',['id'=>true])--}}
    {{--        @component('components.panels.filters.input',['label'=>'Номер','name'=>'number'])@endcomponent--}}
    {{--    @endcomponent--}}
@endsection
