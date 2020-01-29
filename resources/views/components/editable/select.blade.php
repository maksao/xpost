{{--
    Выпадающий список для быстрого редактирования
    v.1.0
--}}
@if( !isset($update) || $update === true )
    <div class="dropdown">
        <div class="dropdown-toggle clickable" data-toggle="dropdown" >
            {{ $selected }}
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="dropdown-header">{{ $title ?? 'Установить значение' }}</div>
            {{ $slot }}
        </div>
    </div>
@else
    {{ $selected }}
@endif