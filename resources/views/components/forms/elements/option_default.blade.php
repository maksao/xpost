{{--
    1.0
    Стартовый элемент списка с предложением выбрать из списка или еще каким )
--}}
<option value="{{ $value ?? '' }}" disabled
        @isset($class) class="{{ $class }}" @endisset
        @isset($selected) selected @endisset
>{{ $label ?? '-- Выберите из списка --' }}</option>