<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($page_title) ? $page_title.' : ' : ''  }}{{ config('app.name', '[Нет данных]') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/public/others/jquery-toast/jquery.toast.css" rel="stylesheet">
</head>
<body>
    <div id="app">

        <div class="shadow fixed-top">
            <nav class="navbar navbar-expand-md bg-primary navbar-dark">
                <div class="container-fluid px-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', '[Нет данных]') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Левая сторона навигации -->
                        @auth
                            <ul class="navbar-nav mr-auto">
                                @employee
                                    @include('layouts.employee.menu')
                                @endemployee
                                @contractor
                                    @include('layouts.contractor.menu')
                                @endcontractor
                            </ul>
                        @endauth
                        <!-- Правая сторона навигации -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Ссылки авторизации -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Вход</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <small>({{ Auth::user()->typeName }})</small> <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @can('return_to_account', Auth::user())
                                            @include('components.dropdowns.link', ['title'=>'Вернуться в свой аккаунт', 'url'=>route('users.return-to-account')])
                                        @endcan
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); $('#logout-form').submit();">
                                            <i class="fas fa-sign-out-alt fa-fw"></i> Выход
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="bg-white">

                {{-- Хлебные крошки --}}

                @auth
                    @yield('breadcrumbs')
                    @isset($breadcrumbs)
                        {{ $breadcrumbs }}
                    @endisset
                @endauth

            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <main class="@hasSection('r_side') col-10 @else col @endif main">

                    {{-- Заголовок страницы --}}

                    @isset($page_title)
                        <div class="page-title">{{ $page_title }}</div>
                    @endisset

                    @yield('content')

                </main>
                @hasSection('r_side')
                    <nav class="col-2 sidebar">
                        @yield('r_side')
                    </nav>
                @endif
            </div>
        </div>

        @include('components.dialogs.confirm')
        @include('components.dialogs.confirm_delete')
        @include('components.editable.editable_modal')
        @stack('modals')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/others/jquery-toast/jquery.toast.js"></script>

    {{-- Выводим всплывающие уведомления --}}
    @include('components.messages.check_notices')

    @stack('scripts')
    <!-- Scripts END-->
</body>
</html>
