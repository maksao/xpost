@component('components.forms.plain.input', array_merge(get_defined_vars()['__data'],[
    'form_group_class' => 'form-group-sm',
    'label' => $label,
    'name'=>$name,
    'value' => request($name),
]))@endcomponent
