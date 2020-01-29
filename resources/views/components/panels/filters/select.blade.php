@component('components.forms.plain.select', array_merge(get_defined_vars()['__data'],[
    'form_group_class' => 'form-group-sm'
]))
    @include('components.forms.elements.option',[
        'label' =>  'Все',
        'value' =>  '',
        'selected'  =>  !request($name) ? true : null
    ])
    {{ $slot }}
@endcomponent