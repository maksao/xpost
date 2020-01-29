@extends('layouts.app')

@section('content')
    @component('components.tables.table')
        @foreach($synonyms as $synonym)
            @component('components.tables.row',['item'=>$synonym])

                <td>{{$synonym->name}}</td>

                {{-- Кнопки действий --}}
                @component('components.tables.cell_actions',['item'=>$synonym])
                    @if($synonyms->count() > 1)
                        @include('components.dropdowns.link_delete', ['url' => route('brands.synonyms.destroy', [$brand->id, $synonym->id])])
                    @endcan
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent
@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['url'=>route('brands.synonyms.store', $brand->id)] ) )
        @slot('mFields')
            @include('components.forms.plain.input',['label'=>'Название', 'name'=>'name', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
        @endslot
        @endcomponent
    @endcomponent
{{--    @include('spr.menu')--}}
@endsection
