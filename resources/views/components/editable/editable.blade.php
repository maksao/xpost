{{--
    Поле быстрого редактирования
    v.1.1
--}}
@if( !isset($update) || $update === true )
    <span data-name="{{ $name }}"
          data-url="{{ $url }}"
          data-type="{{ $type ?? 'text' }}"
          data-title="{{ $title ?? 'Изменение записи' }}"
          data-attr="{{ $attr ?? '' }}"
          id="{{ $name }}{{ $id ?? '' }}"
          @if(isset($value))
            data-value="{{$value}}"
          @elseif($slot == '')
            data-value=""
          @endif
          @isset($required)
            data-required="{{ $required }}"
          @endisset
          @isset($ajax)
            data-ajax="{{ $ajax }}"
          @endisset
          class="editable {{ $class ?? '' }}"
    >@if($slot != '')
        @if(isset($delimiter))
            {!! str_replace($delimiter,'<br>', $slot) !!}
        @else
            {{ $slot }}
        @endif
     @else
        <i class="fa fa-plus-square text-dark"></i>
    @endif
    </span>
@else
    {{ $slot }}
@endif