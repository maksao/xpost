<div class="navbar-nav">

{{--    @can('read',\App\Cargo::class)--}}
{{--        <a class="nav-item nav-link" href="{{ route('cargos.index') }}">Грузы</a>--}}
{{--    @endcan--}}

    {{-- Заказы --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            Заказы и цены
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('e.orders.index') }}">Все заказы</a>
            <a class="dropdown-item" href="{{ route('e.all-orders-positions.index') }}">Позиции всех заказов</a>
            <a class="dropdown-item" href="{{ route('e.orders-tracks-all') }}">Все треки</a>
            <a class="dropdown-item" href="{{ route('e.invoices.index') }}">Инвойсы</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="{{ route('pricelists.index') }}">Прайслисты</a>
{{--            <a class="dropdown-item" href="{{ url('/templates/order_tpl.xlsx') }}">Скачать шаблон заказа</a>--}}
{{--            <div class="dropdown-divider"></div>--}}
{{--            <div class="dropdown-header">Отчеты</div>--}}
{{--            <a class="dropdown-item" href="{{ route('contractors.reports.order-positions-vendor-received-sum') }}">Готово к отгрузке</a>--}}
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
            <a class="dropdown-item" href="{{ route('delivery-services.index') }}">Службы доставки по США</a>
        </div>
    </li>
    @admin
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            Управление
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('e.users.index') }}">Все пользователи</a>
{{--            <a class="dropdown-item" href="{{ route('contractors.index') }}">Контрагенты</a>--}}
{{--            <a class="dropdown-item" href="{{ route('users.index') }}">Сотрудники</a>--}}
        </div>
    </li>
    @endadmin
{{--    @isset($commentsBoxes)--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">--}}
{{--                Коментарии <span class="badge badge-light">{{ $commentsBoxes->sum('comments_count') }}</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                <a class="dropdown-item" href="{{ route('cargos.comments.all') }}">Все коментарии</a>--}}
{{--                @foreach( $commentsBoxes as $cbox )--}}
{{--                    <a class="dropdown-item{{ !$loop->last ? ' border-bottom' : '' }}"--}}
{{--                       href="{{ route('cargos.contractors.boxes.comments.index', [$cbox->cargo_contractor->cargo->id, $cbox->cargo_contractor->id, $cbox->id]) }}"--}}
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

{{--    <li class="nav-item dropdown">--}}
{{--        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">--}}
{{--            Файлы--}}
{{--        </a>--}}
{{--        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--            <a class="dropdown-item" href="{{ route('exports.index') }}">Выгрузки</a>--}}
{{--        </div>--}}
{{--    </li>--}}

</div>
