{{--

    1.1

--}}
<select class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }} {{ $class ?? '' }}"
        name="{{ $name }}"
        {{ isset($id) ? 'id='.$id : '' }}
        {!! isset($attr) ? \App\Helpers::array_to_attr_str($attr) : '' !!}
        {{ isset($required) && $required === true ? ' required' : '' }}
        {{ isset($autofocus) && $autofocus === true ? ' autofocus' : '' }}
        {{ isset($disabled) ? ' disabled' : '' }}
>
    {{-- Можно передать данные массивом --}}
    @if(isset($options))
        @foreach($options as $option_data)
            @component('components.forms.elements.option', $option_data)@endcomponent
        @endforeach
    @endif

    {{ $slot }}

</select>
