@extends('layouts.front')

@section('page_title')
    @include('components.page_title.button_return', [
        'url' => $back_url = route('contractor.order.positions.index', $order->id)
    ])
    {{ $page_title = 'Новая позициия к заказу #'.$order->number }}
@endsection

@section('page_actions')
    @component('components.page_title.buttons.submit')@endcomponent
@endsection

@section('breadcrumbs')
    <a class="breadcrumb-item" href="{{ route('contractor.orders.index') }}">Заказы</a>
    <a href="{{ $back_url }}" class="breadcrumb-item">Заказ #{{ $order->number }}</a>
    <span class="breadcrumb-item active">{{ $page_title }}</span>
@endsection

@section('content')

    @component('components.forms.form', ['url'=>route('contractor.order.positions.store', $order->id),'id'=>'form', 'method'=>'post'])

        {{-- Производитель --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Производитель',
            'name'=>'brand',
            'value'=>old('brand'),
            'required'=>true,
        ])@endcomponent

        {{-- Артикул --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Артикул (номер детали)',
            'name'=>'article',
            'value'=>old('article'),
            'required'=>true,
        ])@endcomponent

        {{-- Название рус --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Наименование (рус)',
            'name'=>'name_rus',
            'value'=>old('name_rus'),
            'required'=>true,
        ])
            @slot('help')
                Наименование детали на русском языке.
            @endslot
        @endcomponent

        {{-- Название англ --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Наименование (англ)',
            'name'=>'name_eng',
            'value'=>old('name_eng'),
            'required'=>true,
        ])
            @slot('help')
                Наименование детали на английском языке.
            @endslot
        @endcomponent

        {{-- Количество --}}
        @component('components.forms.horizontal.input', [
            'type' => 'number',
            'label'=>'Количество',
            'name'=>'quantity',
            'value'=>old('quantity') ?? 1,
            'required'=>true,
            'attr' => ['min'=>1]
        ])@endcomponent

        {{-- Цена заказчика --}}
        @component('components.forms.horizontal.input_group', [
            'addon_before' => '$',
            'label'=>'Цена заказчика',
            'name'=>'contractor_price',
            'value'=>old('contractor_price') ?? 0,
            'required'=>true,
        ])
            @slot('help')
                Максимальная цена за единицу товара, которую Вы готовы заплатить. (0) означает, что Вы согласны с ценой, которую укажет продавец.
            @endslot
        @endcomponent

        {{-- Ссылка на товар --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Ссылка на товар',
            'name'=>'url',
            'value'=>old('url')
        ])
            @slot('help')
                При указании ссылки необходимо указывать протокол http:// или https://
            @endslot
        @endcomponent

        {{-- Комментарий --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Комментарий',
            'name'=>'contractor_comment',
            'value'=>old('contractor_comment')
        ])@endcomponent

    @endcomponent

@endsection