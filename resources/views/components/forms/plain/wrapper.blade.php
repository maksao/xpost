{{--
    v.1.0
    Обертка для полей обычной формы

    name
    label
    label_class
    id
    required
    help
    help-color
--}}
<div class="form-group {{ $form_group_class ?? '' }}">
    @isset($label)
        <label @isset($id) for="{{ $id }}" @endisset>
            <span class="form-plain-label {{ $label_class ?? '' }}">{{ $label }}</span>
            @includeWhen(isset($required), 'components.forms.presets.badge_required')
        </label>
    @endisset

    <div class="row">
        {{-- Занимает оставшееся пространство или указанную ширину. --}}
        <div class="col{{ isset($field_col) ? '-'.$field_col : '' }}">
            {{ $slot }}
            @isset($help)
                <div class="text-help{{ isset($help_color) ? ' text-'.$help_color : '' }}">
                    {{ $help }}
                </div>
            @endisset
            @isset($name)
                @if ($errors->has($name))
                    <div class="invalid-feedback">
                        {{ $errors->first($name) }}
                    </div>
                @endif
            @endisset
        </div>
    </div>
</div>