@extends('layouts.front')

@section('page_title')
    @include('components.page_title.button_return', ['url' => $back_url = route('delivery-types.index')])
    {{ $page_title = 'Редактирование пользователя' }}
@endsection

@section('page_actions')
    <button class="btn btn-sm btn-primary" form="form">
        <i class="fa fa-save fa-fw"></i> <span class="hidden-sm-down">Сохранить</span>
    </button>
@endsection

@section('breadcrumbs')
    <a href="{{ $back_url }}" class="breadcrumb-item">Типы доставки</a>
    <span class="breadcrumb-item active">{{ $page_title }}</span>
@endsection

@section('content')

    @component('components.forms.form', ['url'=>route('delivery-types.update', $deliveryType->id),'id'=>'form', 'method'=>'put'])

        {{-- Позиция --}}
        @component('components.forms.horizontal.input', [
            'type'=>'number',
            'label'=>'Позиция',
            'name'=>'pos',
            'value'=>$deliveryType->pos,
            'required'=>true,
            'attr' => ['min'=>1]
        ])@endcomponent
        {{-- Название --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Название',
            'name'=>'name',
            'value'=>$deliveryType->name,
            'required'=>true
        ])@endcomponent
        {{-- Комментарий --}}
        @component('components.forms.horizontal.input', [
            'label'=>'Комментарий',
            'name'=>'comment',
            'value'=>$deliveryType->comment
        ])@endcomponent

    @endcomponent

@endsection