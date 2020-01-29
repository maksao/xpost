{{--

    v.1.0

--}}
<span class="switch {{ isset($size) ? 'switch-'.$size : 'switch-xs' }} switch-{{ $theme ?? 'primary' }}">
    <input
        type="checkbox"
        @isset($id)
            id="switch{{ $id }}"{{ $checked ? ' checked' : '' }}
        @endisset
        @isset($name)
            name="{{ $name }}"
        @endisset
        @isset($value)
            value="{{ $value }}"
        @endisset
        @isset($attr)
            {!! \App\Helpers::array_to_attr_str($attr) !!}
        @endisset
        data-toggle='switch-checkbox'
    >
    <label for="switch{{ $id ?? $name }}" class="{{ $class ?? '' }}">{{ $label ?? '' }}</label>
</span>