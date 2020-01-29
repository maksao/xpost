{{--
    v.1.1
    Группа радиокнопок
--}}
<fieldset class="form-group {{ $form_group_class ?? '' }}">
    @isset($label)
        <legend class="col-form-label pt-0">
            {{ $label }}
            @includeWhen(isset($required), 'components.forms.presets.badge_required')
        </legend>
    @endif
    @isset($radios)
        @foreach($radios as $key => $data)
            @include('components.forms.elements.radio',array_merge($data, ['id'=>$name.$key, 'name'=>$name]))
        @endforeach
    @endif
    @isset($slot)
        {{ $slot }}
    @endisset
    @isset($help)
        <div class="text-help{{ isset($help_color) ? ' text-'.$help_color : '' }}">{{ $help }}</div>
    @endisset
    @if(isset($name) && $errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</fieldset>
