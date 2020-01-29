@extends('layouts.app')

@section('content')
    @component('components.forms.form',['url'=>route('e.users.store'), 'id'=>'form', 'method'=>'post'])
        <div class="d-flex">

            {{-- Колонка 1 --}}

            <div class="col">

                <div class="card border-primary mb-3">
                    <div class="card-header">
                        Данные
                    </div>
                    <div class="card-body">

                        {{-- Имя --}}

                        @component('components.forms.plain.input',[
                            'label' => 'Имя',
                            'name' => 'name',
                            'value' => old('name'),
                            'required' => true,
                        ])@endcomponent

                        <div class="d-flex">

                            <div class="w-50 mr-2">
                                {{-- Тип пользователя --}}

                                @component('components.forms.plain.select',['label'=>'Тип пользователя','name'=>'type','required' => true,])
                                    @include('components.forms.elements.options',['options'=>[
                                        ['label'=>'Контрагент', 'value'=>'C', 'selected'=>old('type') == 'C' ? true : null],
                                        ['label'=>'Сотрудник', 'value'=>'E', 'selected'=>old('type') == 'E' ? true : null]
                                    ]])
                                @endcomponent
                            </div>
                            <div class="w-50">
                                {{-- Администратор --}}

                                @include('components.forms.plain.checkbox',[
                                    'label'=>'Администратор',
                                    'name'=>'is_admin',
                                    'value'=>1,
                                    'help' => 'Не работает если выбран тип "Контрагент"',
                                    'checked' => old('is_admin') ? true : null
                                ])
                            </div>
                        </div>
                        {{-- Комментарий --}}

                        @component('components.forms.plain.textarea',[
                            'label' => 'Комментарий',
                            'name' => 'comment',
                            'value' => old('comment'),
                            'attr' => ['rows'=>2],
                            'help' => 'Служебная информация, которую видят только сотрудники'
                        ])@endcomponent

                    </div>
                </div>

            </div>

            {{-- Колонка 2 --}}

            <div class="col">

                {{-- Аккаунт--}}

                <div class="card border-primary mb-3">
                    <div class="card-header">
                        Аккаунт
                    </div>
                    <div class="card-body">

                        {{-- Email --}}

                        @component('components.forms.plain.input',[
                            'type' => 'email',
                            'label' => 'Эл.адрес',
                            'name' => 'email',
                            'value' => old('email'),
                            'required' => true,
                            'help' => 'Будет использоваться как логин при авторизации пользователя'
                        ])@endcomponent

                        {{-- Password --}}

                        @include('components.forms.plain.preset.password_inline', ['generator'=>true, 'generator_mini'=>true])

                    </div>
                </div>


            </div>

        </div>
    @endcomponent
@endsection

{{-- Правый блок --}}

@section('r_side')

    {{-- Инструменты --}}

    @component('components.panels.toolbox')
        @include('components.panels.menu.button_submit')
    @endcomponent


@endsection
