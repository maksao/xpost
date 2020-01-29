{{--

    v.1.1

--}}
<input
        @if(isset($type))
            @switch($type)
                @case('price')
                    type="number" step="0.01"
                    @break

                @case('weight')
                    type="number" step="0.001"
                    @break

                @default
                    type="{{ $type }}"
            @endswitch
        @else
            type="text"
        @endif
        class="form-control{{ (isset($name) && $errors->has($name)) ? ' is-invalid' : '' }} {{ $class ?? '' }}"
        @isset($name)
            name="{{ $name }}"
        @endisset
        @isset($id)
            id="{{ $id }}"
        @endisset
        @isset($value)
            value="{{ $value }}"
        @endisset
        @isset($placeholder)
            placeholder="{{ $placeholder }}"
        @endisset
        @isset($required)
            required
        @endisset
        @isset($autofocus)
            autofocus
        @endisset
        @isset($readonly)
            readonly
        @endisset
        @isset($attr)
            {!! \App\Helpers::array_to_attr_str($attr) !!}
        @endisset
>