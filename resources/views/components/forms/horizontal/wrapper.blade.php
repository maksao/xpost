{{--
    17.08.2017
    Обертка для полей горизонтальной формы

    параметры:

    name
    label
    label_col = 2
    label_align = 'text-rght'
    id
    field_col
    required
    help
    help-color
--}}
<div class="form-group row {{ $form_group_class ?? '' }}">
    @if(isset($label))
        <label
                class="col-{{ $label_col ?? 2 }} col-form-label {{ $label_align ?? 'text-right' }}"
                @isset($id)
                    for="{{ $id }}"
                @endisset
        >
            {{ $label }}
            @includeWhen(isset($required), 'components.forms.presets.badge_required')
        </label>
    @else
        <div class="col-{{ $label_col ?? 2 }}"></div>
    @endif

    {{-- Занимает оставшееся пространство или указанную ширину. --}}
    <div class="col{{ isset($field_col) ? '-'.$field_col : '' }}">

        {{ $slot }}

        @isset($help)
            <div class="text-help{{ isset($help_color) ? ' text-'.$help_color : '' }}">{{ $help }}</div>
        @endisset
        @isset($name)
            @if ($errors->has($name))
                <div class="invalid-feedback">{{ $errors->first($name) }}</div>
            @endif
        @endisset
    </div>
    {{ $after ?? '' }}
</div>