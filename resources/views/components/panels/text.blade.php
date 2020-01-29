{{--
    Панель с текстом с заголовком
    можно использовать темы
    по умолчанию раскрыта
--}}
<div class="list-group {{ $margin ?? 'mb-2' }}">
    <div class="list-group-item list-group-item-{{ $theme ?? 'ligth' }} clickable" data-toggle="collapse" data-target="#panel-{{ $id ?? 'message' }}">
        <h6 class="mb-0">
            {{ $header ?? 'Текст заголовка' }}
        </h6>
    </div>
    <div class="collapse{{ isset($hide) ? '' : ' show' }}" id="panel-{{ $id ?? 'message' }}">
        <div class="list-group-item {{ isset($class) ? ' '.$class : '' }}">
            {{ $slot }}
        </div>
    </div>
</div>
