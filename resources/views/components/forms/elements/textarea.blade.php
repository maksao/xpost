{{--

    18.08.2017

--}}
<textarea class="form-control{{ (isset($name) && $errors->has($name)) ? ' is-invalid' : '' }} {{ $class ?? '' }}"
    @isset($name)
        name="{{ $name }}"
    @endisset
    @isset($id)
        id="{{ $id }}"
    @endisset
    @isset($required)
        required
    @endisset
    @isset($readonly)
        readonly
    @endisset
    @isset($attr)
        {!! \App\Helpers::array_to_attr_str($attr) !!}
    @endisset
>{{ $value ?? '' }}</textarea>
