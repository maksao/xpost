@component('components.forms.plain.radio_group', array_merge(get_defined_vars()['__data'],[
    'form_group_class' => 'form-group-sm',
    'radios' => null
]))
    @isset($radios)
        @foreach($radios as $key => $data)
            @include('components.panels.filters.radio',array_merge($data, ['id'=>$name.$key]))
        @endforeach
    @endif
    {{ $slot }}
@endcomponent