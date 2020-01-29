@component('components.forms.plain.radio_group', array_merge(get_defined_vars()['__data'],[
    'form_group_class' => 'form-group-sm',
    'radios' => null
]))
    @include('components.panels.filters.radio',[
        'id'=>$name.'_all',
        'label' => 'Все',
        'name'=>$name,
        'value' => '',
        'checked' => in_array(request($name), ['Y','N']) ? null : true,
        'inline' => true
    ])
    @include('components.panels.filters.radio',[
        'id'=>$name.'_y',
        'label' => 'Да',
        'name'=>$name,
        'value' => 'Y',
        'checked' => request($name) === 'Y' ? true : null,
        'inline' => true
    ])
    @include('components.panels.filters.radio',[
        'id'=>$name.'_n',
        'label' => 'Нет',
        'name'=>$name,
        'value' => 'N',
        'checked' => request($name) === 'N' ? true : null,
        'inline' => true
    ])
@endcomponent
