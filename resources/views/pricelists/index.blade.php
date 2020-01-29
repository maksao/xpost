@extends('layouts.app')

@section('content')
    @component('components.tables.table',[

                'header' => [
                    'Название',
                    'Цены',
                    'Создан',
                    'Обновление',
                    'Комментарий',
                    '#actions#'
                ]
            ])
        @foreach($pricelists as $plist)
            @component('components.tables.row',['item' => $plist, 'class' => 'small'])

                {{-- Название --}}

                <td>
                    @component('components.editable.editable', [
                        'ajax' => true,
                        'title' => 'Название',
                        'name' => 'name',
                        'url' => route('pricelists.field.update', $plist->id),
                        'id' => $plist->id,
                    ]){{ $plist->name }}@endcomponent
                </td>

                {{-- Цены --}}

                <td>
                    @component('components.badges.count_with_link',[
                        'url' => route('pricelists.show',$plist->id),
                        'count' => $plist->prices_count
                    ])@endcomponent
                </td>

                {{-- Создан --}}

                <td>
                    {{ $plist->created_at->format('d.m.Y H:i') }}
                </td>

                {{-- Обновление --}}

                <td>
                    @if($plist->status === 1)
                        <span class="text-blue"><i class="fas fa-spinner fa-spin"></i> обновляется...</span>
                    @elseif($plist->status === 2)
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> ошибка обновления</span>
                    @else
                        {{ $plist->last_updated_at ? $plist->last_updated_at->format('d.m.Y H:i') : 'никогда' }}
                    @endif
                </td>

                {{-- Коментарий --}}

                <td>
                    @component('components.editable.editable', [
                      'ajax' => true,
                      'title' => 'Коментарий',
                      'name' => 'comment',
                      'url' => route('pricelists.field.update', $plist->id),
                      'id' => $plist->id,
                  ]){{ $plist->comment }}@endcomponent
                </td>

                {{-- Контекстное меню --}}

                @component('components.tables.cell_actions',['item'=>$plist])
                    @can('upload', $plist)
                        @include('components.dropdowns.link_modal_form', [
                            'id'=>'mUpload',
                            'title'=>'Загрузить цены',
                            'url'=>route('pricelists.upload',$plist->id)
                        ])
                    @endcan
                    @if($plist->prices_count)
                        @include('components.dropdowns.link', ['title'=>'Очистить прайслист', 'url'=>route('pricelists.clear',$plist->id), 'confirm'=>true])
                    @endif
                    @include('components.dropdowns.link_delete', ['url'=>route('pricelists.destroy',$plist->id)])
                    @include('components.dropdowns.link_show_logs', ['params' => ['pricelist', $plist->id]])
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent

    {{-- Окно загрузки файла --}}
    @push('modals')
        @component('components.dialogs.modal_w_form',[
            'title'=>'Загрузка прайса',
            'id' => 'mUpload',
            'files'=>true,
            'required_notice' => false
        ])
            @include('components.forms.plain.input',[
                'type' => 'file',
                'label' => 'Укажите файл',
                'name' => $filename ?? 'userfile',
                'required' => true
            ])
            <ul class="small">
                <li>Файл должен быть формата <b class="text-blue">xlsx</b></li>
                <li>Заголовки должны отсутствовать. Считывание начинается с первой строки</li>
                <li>Данные должны располагаться в следущем порядке: <br>
                    <b class="text-blue">артикул | бренд | наименование | цена | вес | core | примечание</b>
                </li>
            </ul>
        @endcomponent
    @endpush

@endsection

{{-- Правый блок --}}

@section('r_side')
    @component('components.panels.toolbox')
        @component('components.panels.menu.button_modal_create', ['url'=>route('pricelists.store')] ) )
            @slot('mFields')
                @include('components.forms.plain.input',['label'=>'Название', 'name'=>'name', 'required'=>true, 'errors'=>new \Illuminate\Support\MessageBag])
                @include('components.forms.plain.textarea',['label'=>'Описание', 'name'=>'comment', 'errors'=>new \Illuminate\Support\MessageBag ])
            @endslot
        @endcomponent
    @endcomponent

{{--    @component('components.panels.filters',[--}}
{{--        'sort'=>[--}}
{{--            'Тип' => 'type',--}}
{{--            'Имя' => 'name',--}}
{{--            'Email' => 'email',--}}
{{--        ]--}}
{{--    ])--}}
{{--        @component('components.panels.filters.select',['label'=>'Тип','name'=>'type'])--}}
{{--            @include('components.forms.elements.options',[ 'options' => [--}}
{{--            ['label' => 'Контрагент', 'value' => 'C', 'selected' => request('type') == 'C' ? true : null],--}}
{{--            ['label' => 'Сотрудник', 'value' => 'E', 'selected' => request('type') == 'E' ? true : null],--}}
{{--        ]])@endcomponent--}}
{{--        @component('components.panels.filters.input',['label'=>'Имя','name'=>'name'])@endcomponent--}}
{{--        @component('components.panels.filters.input',['label'=>'Эл.почта','name'=>'email'])@endcomponent--}}
{{--    @endcomponent--}}
@endsection
