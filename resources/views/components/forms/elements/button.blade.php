<button class="btn btn-{{ $color ?? 'primary' }}{{ isset($class) ? ' '.$class : '' }}"
    @isset($type)
        type="{{ $type }}"
    @endisset
    @isset($attr)
        {!! \App\Helpers::array_to_attr_str($attr) !!}
    @endisset
    @isset($disabled) disabled @endisset
>{{ $text ?? 'Кнопка' }}</button>
