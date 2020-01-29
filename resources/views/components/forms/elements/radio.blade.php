{{--

    v.1.0

--}}
<label class="custom-control custom-radio{{ isset($inline) ? ' custom-control-inline' : '' }} {{ $class ?? '' }}">
    <input type="radio" class="custom-control-input" id="{{ $id }}"
            @isset($name) name="{{ $name }}" @endisset
            @isset($value) value="{{ $value }}" @endisset
            @isset($checked) checked @endisset
            @isset($disabled) disabled @endisset
            @isset($required) required @endisset
            @isset($attr)
                {!! \App\Helpers::array_to_attr_str($attr) !!}
            @endisset
    >
    <label class="custom-control-label" for="{{ $id }}">{{ $label ?? '' }}</label>
</label>
