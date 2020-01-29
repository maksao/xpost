@extends('layouts.front')

@section('page_title')
    @include('components.page_title.button_return', ['url' => $back_url = route('delivery-types.index')])
    {{ $page_title = 'Новый тип доставки' }}
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

    @component('components.forms.form', ['url'=>route('delivery-types.store'),'id'=>'form', 'method'=>'post'])

        {{-- Название --}}
        @component('components.forms.horizontal.input', ['label'=>'Название', 'name'=>'name', 'value'=>old('name'), 'required'=>true])@endcomponent
        {{-- Комментарий --}}
        @component('components.forms.horizontal.input', ['label'=>'Комментарий', 'name'=>'comment', 'value'=>old('comment')])@endcomponent

    @endcomponent

@endsection