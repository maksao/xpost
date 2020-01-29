@extends('layouts.app')

@section('content')

    @component('components.tables.table', [
                    'header' => [
                        '#pos#',
                        'Название',
                        'Описание',
                        '#actions#'
                    ],
                ])

        @foreach($types as $type)

            @component('components.tables.row',['item'=>$type])

                {{-- Поз. --}}

                @include('components.tables.cell_position',['item' => $type, 'pos_route_prefix'=>'delivery-types'])

                {{-- Название --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название',
                        'name' => 'name',
                        'url' => route('delivery-types.field.update', $type->id),
                        'id' => $type->id,
                    ]){{ $type->name }}@endcomponent
                </td>

                {{-- Описание --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Описание',
                        'name' => 'description',
                        'url' => route('delivery-types.field.update', $type->id),
                        'id' => $type->id,
                    ]){{ $type->description }}@endcomponent
                </td>

                @component('components.tables.cell_actions',['item'=>$type])
                    @include('components.dropdowns.link_delete',['url'=>route('delivery-types.destroy', $type->id)])
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['title'=>'Добавить запись', 'url'=>route('delivery-types.store')] ) )
            @slot('mFields')
                @include('components.forms.plain.input',['label'=>'Название', 'name'=>'name', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                @include('components.forms.plain.input',['label'=>'Описание', 'name'=>'description', 'errors'=>new \Illuminate\Support\MessageBag])
            @endslot
        @endcomponent
    @endcomponent
@endsection
