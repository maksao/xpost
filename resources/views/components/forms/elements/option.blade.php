{{--
        v 1.0
--}}
<option @isset($class) class="{{ $class }}" @endisset
        @isset($value) value="{{ $value }}" @endisset
        @isset($disabled) disabled @endisset
        @isset($selected) selected @endisset
        @isset($attr){!! \App\Helpers::array_to_attr_str($attr) !!}@endisset
>{{ $label }}</option>