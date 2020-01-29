{{--

    Выпадающий список в навигации
    v.1.1

--}}

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ $title }}</a>
    <div class="dropdown-menu dropdown-menu-{{ $menu_align ?? 'left' }}">
        {{ $slot }}
    </div>
</li>
