@extends('layouts.app')

@section('content')

    @component('components.tables.table', [
                    'header' => [
                        'Название',
                        'Ссылка',
                        'Описание',
                        '#actions#'
                    ],
                ])

        @foreach($items as $service)

            @component('components.tables.row',['item'=>$service])

                {{-- Название --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название',
                        'name' => 'name',
                        'url' => route('delivery-services.field.update', $service->id),
                        'id' => $service->id,
                    ]){{ $service->name }}@endcomponent
                </td>

                {{-- Ссылка --}}

                <td>
                    @component('components.editable.editable', [
                        'title' => 'Ссылка',
                        'name' => 'url',
                        'url' => route('delivery-services.field.update', $service->id),
                        'id' => $service->id,
                    ]){{ $service->url }}@endcomponent
                    @if($service->url)
                        <div class="text-sm">[<a href="{{ $service->url }}" target="_blank">перейти</a>]</div>
                    @endif
                </td>

                {{-- Описание --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Описание',
                        'name' => 'description',
                        'url' => route('delivery-services.field.update', $service->id),
                        'id' => $service->id,
                    ]){{ $service->description }}@endcomponent
                </td>

                @component('components.tables.cell_actions',['item'=>$service])
                    @include('components.dropdowns.link_delete',['url'=>route('delivery-services.destroy', $service->id)])
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent

@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['title'=>'Добавить запись', 'url'=>route('delivery-services.store')] ) )
            @slot('mFields')
                @include('components.forms.plain.input',['label'=>'Название', 'name'=>'name', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                @include('components.forms.plain.input',['label'=>'Ссылка', 'name'=>'url', 'errors'=>new \Illuminate\Support\MessageBag])
                @include('components.forms.plain.input',['label'=>'Описание', 'name'=>'description', 'errors'=>new \Illuminate\Support\MessageBag])
            @endslot
        @endcomponent
    @endcomponent
@endsection
