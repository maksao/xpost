{{--
    v.1.1
    Группа чекбоксов
--}}
<fieldset class="form-group {{ $form_group_class ?? '' }}">
    @isset($label)
        <legend class="col-form-label pt-0">
            {{ $label }}
            @includeWhen(isset($required), 'components.forms.presets.badge_required')
        </legend>
    @endif
    @isset($checkboxes)
        @foreach($checkboxes as $key => $data)
            @include('components.forms.elements.checkbox',array_merge($data, ['id'=>$name.$key]))
        @endforeach
    @endif
    {{ $slot }}
    @isset($help)
        <div class="text-help{{ isset($help_color) ? ' text-'.$help_color : '' }}">{{ $help }}</div>
    @endisset
    @if(isset($name) && $errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</fieldset>
