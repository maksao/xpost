{{--
    v.1.0
    Группа радиокнопок
--}}
<fieldset class="form-group {{ $form_group_class ?? '' }}">
    <div class="row">
        @isset($label)
            <legend class="col-form-label col-{{ $label_col ?? 2 }} pt-0 text-right">
                {{ $label }}
                @includeWhen(isset($required), 'components.forms.presets.badge_required')
            </legend>
        @endif
        <div class="col{{ isset($label_col) ? '-'.(12 - $label_col) : '' }}{{ !isset($label) ? ' offset-'.($label_col ?? 2) : '' }}">
            @isset($radios)
                @foreach($radios as $key => $data)
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
        </div>
    </div>
</fieldset>
