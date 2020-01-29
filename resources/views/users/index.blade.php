@extends('layouts.app')

@section('content')
    @component('components.tables.table',[
                'header' => [
                    'Тип','Имя','Эл.адрес','Комментарий','#actions#'
                ]
            ])
        @foreach($users as $user)
            @component('components.tables.row',['item' => $user])

                {{-- Иконка типа --}}

                <td>
                    @if($user->isEmployee())
                        @if($user->isAdmin())
                            <i class="fas fa-user-tie text-danger" data-toggle="tooltip" title="Сотрудник (администратор)"></i>
                        @else
                            <i class="fas fa-user-tie text-primary" data-toggle="tooltip" title="Сотрудник"></i>
                        @endif
                    @else
                        <i class="fas fa-user" data-toggle="tooltip" title="Контрагент"></i>
                    @endif
                </td>

                {{-- Имя/Название --}}

                <td>
                    {{ $user->name }}
                </td>

                {{-- Email --}}

                <td>
                    <span id="email{{$user->id}}">{{ $user->email }}</span>
                    @component('components.buttons.copy_to_cb',['id'=>'email'.$user->id])@endcomponent
                </td>

                {{-- Коментарий --}}

                <td>
                    {{ $user->comment }}
                </td>

                {{-- Контекстное меню --}}

                @component('components.tables.cell_actions',['item'=>$user])
{{--                    @include('components.dropdowns.header',['title'=>'Заказы'])--}}
{{--                    @can('create', \App\Order::class)--}}
{{--                        @include('components.dropdowns.link', ['url'=>route('orders.index',['c_id'=>$user->id]), 'title'=>'Все заказы'])--}}
{{--                        @include('components.dropdowns.link', ['url'=>route('orders.create',['c_id'=>$user->id]), 'title'=>'Создать заказ'])--}}
{{--                        @include('components.dropdowns.link', ['url'=>route('users.order-template', $user->id), 'title'=>'Настроить шаблон'])--}}
{{--                        @include('components.dropdowns.divider')--}}
{{--                    @endcan--}}
                    @can('login_as', $user)
                        @include('components.dropdowns.link', ['url'=>route('e.users.login-as',$user->id), 'title'=>'Действовать от лица пользователя'])
                    @endcan
                    @include('components.dropdowns.link_edit', ['url'=>route('e.users.edit',$user->id)])
{{--                    @can('roles', $user)--}}
{{--                        @include('components.dropdowns.link', ['title'=>'Роли','url'=>route('users.roles',$user->id)])--}}
{{--                    @endcan--}}
{{--                    @can('delete', $user)--}}
{{--                        @include('components.dropdowns.link_delete', ['url'=>route('users.destroy',$user->id)])--}}
{{--                    @endcan--}}
{{--                    @include('components.dropdowns.link_show_logs', ['params' => ['user', $user->id]])--}}
                @endcomponent
            @endcomponent
        @endforeach
    @endcomponent
@endsection

{{-- Правый блок --}}

@section('r_side')
    @component('components.panels.toolbox')
        @include('components.panels.menu.link_create', ['title'=>'Создать пользователя', 'url' => route('e.users.create')])
    @endcomponent

    @component('components.panels.filters',[
        'sort'=>[
            'Тип' => 'type',
            'Имя' => 'name',
            'Email' => 'email',
        ]
    ])
        @component('components.panels.filters.select',['label'=>'Тип','name'=>'type'])
            @include('components.forms.elements.options',[ 'options' => [
            ['label' => 'Контрагент', 'value' => 'C', 'selected' => request('type') == 'C' ? true : null],
            ['label' => 'Сотрудник', 'value' => 'E', 'selected' => request('type') == 'E' ? true : null],
        ]])@endcomponent
        @component('components.panels.filters.input',['label'=>'Имя','name'=>'name'])@endcomponent
        @component('components.panels.filters.input',['label'=>'Эл.почта','name'=>'email'])@endcomponent
    @endcomponent
@endsection
