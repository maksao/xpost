@extends('layouts.front')

@section('page_title')
    @include('components.page_title.button_return', ['url' => $back_url = route('contractor.orders.index')])
    {{ $page_title = 'Редактирование заказа' }}
@endsection

@section('page_actions')
    @component('components.page_title.buttons.submit')@endcomponent
    {{--<button class="btn btn-sm btn-primary" form="form">--}}
        {{--<i class="fa fa-save fa-fw"></i> <span class="hidden-sm-down">Сохранить</span>--}}
    {{--</button>--}}
@endsection

@section('breadcrumbs')
    <a href="{{ $back_url }}" class="breadcrumb-item">Заказы</a>
    <span class="breadcrumb-item active">{{ $page_title }}</span>
@endsection

@section('content')

    @component('components.forms.form', ['url'=>route('contractor.orders.update', $order->id),'id'=>'form', 'method'=>'put'])

        {{-- Номер заказа--}}
        @component('components.forms.horizontal.input', [
            'label'=>'Номер',
            'name'=>'number',
            'value'=>$order->number,
            'required'=>true
        ])@endcomponent

        {{-- Тип доставки --}}
        @component('components.forms.horizontal.select', ['label'=>'Тип доставки', 'name'=>'delivery_type_id', 'required'=>true])
            @foreach($delivery_types as $delivery_type)
                @component('components.forms.elements.option',[
                    'label' => $delivery_type->name,
                    'value' => $delivery_type->id,
                    'selected' => $delivery_type->id == $order->delivery_type_id ? true : null
                ])@endcomponent
            @endforeach
        @endcomponent

    @endcomponent

@endsection