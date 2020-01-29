{{--
    v.1.1
--}}
<div class="custom-control custom-checkbox{{ isset($inline) ? ' custom-control-inline' : '' }} {{ isset($text) ? '' : ' text-hide' }}">
    <input type="checkbox" class="custom-control-input"
            id="customCheck_{{ $id ?? $name }}"
            @isset($name) name="{{ $name }}" @endisset
            @isset($value) value="{{ $value }}" @endisset
            @isset($form) form="{{ $form }}" @endisset
            @if(isset($checked) && $checked) checked @endif
            @isset($disabled) disabled @endisset
            @isset($required) required @endisset
            @isset($attr)
                {!! \App\Helpers::array_to_attr_str($attr) !!}
            @endisset
    >
    <label class="custom-control-label"  for="customCheck_{{ $id ?? $name }}">{{ $text ?? ''}}</label>
</div>
