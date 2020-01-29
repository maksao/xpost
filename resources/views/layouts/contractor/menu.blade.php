<div class="navbar-nav">

    {{-- Заказы --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            Заказы
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('c.orders.index') }}">Все заказы</a>
            <a class="dropdown-item" href="{{ route('c.all-orders-positions.index') }}">Позиции всех заказов</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="{{ route('pricelists.index') }}">Прайслисты</a>

{{--                <div class="dropdown-divider"></div>--}}
{{--                <a class="dropdown-item" href="{{ url('/templates/order_tpl.xlsx') }}">Скачать шаблон заказа</a>--}}
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            Справочники
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('products.index') }}">Товар</a>
            <a class="dropdown-item" href="{{ route('brands.index') }}">Бренды</a>
            <a class="dropdown-item" href="{{ route('delivery-types.index') }}">Типы доставки</a>
            {{--            <a class="dropdown-item" href="{{ route('countries.index') }}">Страны</a>--}}
        </div>
    </li>

{{--    @isset($commentsBoxes)--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">--}}
{{--                Коментарии <span class="badge badge-light">{{ $commentsBoxes->sum('comments_count') }}</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                @foreach( $commentsBoxes as $cbox )--}}
{{--                    <a class="dropdown-item{{ !$loop->last ? ' border-bottom' : '' }}"--}}
{{--                       href="{{ route('contractor.cargos.boxes.comments', [$cbox->cargo_contractor->cargo->id, $cbox->id]) }}"--}}
{{--                    >--}}
{{--                        <div class="d-flex align-items-center justify-content-between">--}}
{{--                            <div class="small">--}}
{{--                                <div>Груз: <strong>{{ $cbox->cargo_contractor->cargo->number }}</strong></div>--}}
{{--                                <div>Место: <strong>{{ $cbox->number }}</strong></div>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <span class="badge badge-primary badge-pill">{{ $cbox->comments_count }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </li>--}}
{{--    @endisset--}}

{{--    <a class="nav-item nav-link" href="{{ route('help') }}">Помощь</a>--}}

</div>
