@extends('layouts.app')

@section('content')
    @component('components.tables.table', [
        'header' => ['Название','Наценка %','Синонимы','#actions#'],
    ])
        @foreach($brands as $brand)
            @component('components.tables.row',['item'=>$brand])

                {{-- Название --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название',
                        'name' => 'name',
                        'url' => route('brands.field.update', $brand->id),
                        'id' => $brand->id,
                    ]){{ $brand->name }}@endcomponent
                </td>

                {{-- Наценка --}}

                <td>
                    @if(Auth::user()->isEmployee())
                        @component('components.editable.editable', [
                            'ajax' => true,
                            'type' => 'number',
                            'title' => 'Наценка',
                            'name' => 'markup',
                            'url' => route('brands.field.update', $brand->id),
                            'id' => $brand->id,
                        ]){{ $brand->markup }}@endcomponent
                    @else
                        {{ $brand->markup }}
                    @endif
                </td>

                {{-- Синонимы --}}

                <td>
                    @component('components.badges.count_with_link',[
                        'url' => route('brands.synonyms.index',$brand->id),
                        'count' => $brand->synonyms_count
                    ])@endcomponent
                </td>

                @component('components.tables.cell_actions',['item'=>$brand])
{{--                    @include('components.dropdowns.link_modal_form', ['id' => 'dSelectBrand', 'title'=>'Сделать синонимом', 'url'=>route('e.brands.convert-to-synonym', $brand->id)])--}}
                    @include('components.dropdowns.link_delete', ['url' => route('brands.destroy', $brand->id)])
                    @include('components.dropdowns.link_show_logs', ['params' => ['brand', $brand->id]])
                @endcomponent

            @endcomponent
        @endforeach
    @endcomponent

    @push('modals')
        @component('components.dialogs.modal_w_form',['id'=>'dSelectBrand', 'title'=>'Выбор бренда', 'required_notice'=>false])
            <p>Выберите бренд, синонимом которого, Вы хотите сделать текущий бренд</p>
            <div class="form-group">
                @component('components.forms.plain.select',['name'=>'parent_id'])
                    @foreach($brands as $brand)
                        @include('components.forms.elements.option', [
                            'label'=>$brand->name,
                            'value'=>$brand->id
                        ])
                    @endforeach
                @endcomponent
                <div class="alert alert-warning">
                    Внимание! Весь товар привязанный к текущему бренду будет привязан к выбранному.
                    Все синонимы текущего бренда станут синонимами выбранного.
                </div>
            </div>
        @endcomponent
    @endpush
@endsection

{{-- Правое меню --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['url'=>route('brands.store')] ) )
            @slot('mFields')
                @include('components.forms.plain.input',['label'=>'Название', 'name'=>'name', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                @include('components.forms.plain.input',[
                    'type'=>'number',
                    'label'=>'Наценка',
                    'name'=>'markup',
                    'value'=>0,
                    'attr' => ['min'=>0],
                    'required'=>true,
                    'errors'=>new \Illuminate\Support\MessageBag,
                    'readonly' => Auth::user()->isEmployee() ? null : true,
                ])
            @endslot
        @endcomponent
    @endcomponent

    {{-- Фильтры --}}

    @component('components.panels.filters',['id'=>true])
        @component('components.panels.filters.input',['label'=>'Название','name'=>'name'])@endcomponent
    @endcomponent
{{--    @include('spr.menu',['active_code'=>'brands'])--}}
@endsection
