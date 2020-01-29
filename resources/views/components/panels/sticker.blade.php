{{--
    Стикер с текстом
    можно использовать темы
    всегда раскрыт
--}}
<div class="card text-{{ isset($theme) ? 'white' : 'black' }} bg-{{ $theme ?? 'light' }} {{ $margin ?? 'mb-2' }} {{ $class ?? '' }}">
    <div class="card-body">
        @isset($header)
            <h5 class="card-title">{{ $header }}</h5>
        @endisset
        <p class="card-text">{{ $slot }}</p>
    </div>
</div>
