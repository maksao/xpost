@component('components.forms.plain.select', array_merge(get_defined_vars()['__data'],[
    'form_group_class' => 'form-group-sm',
    'label' => 'Сортировать по полю:',
    'name' => 'sort'
]))
    @include('components.forms.elements.option',['label' =>  'Без сортировки','value' =>  ''])
    @isset($fields)
        @foreach($fields as $label => $value)
            @include('components.forms.elements.option',[
                'label' =>  $label,
                'value' =>  $value,
                'selected'  =>  request('sort') == $value ? true : null
            ])
        @endforeach
    @endisset
    {{ $slot }}
@endcomponent
@component('components.forms.plain.select', [
    'form_group_class' => 'form-group-sm',
    'name' => 'sort_dir'
])
    @include('components.forms.elements.option',['label' =>  'По возрастанию','value' =>  'a'])
    @include('components.forms.elements.option',[
        'label' =>  'По убыванию',
        'value' =>  'd',
        'selected'=>request('sort_dir') == 'd' ? true : null
    ])
@endcomponent