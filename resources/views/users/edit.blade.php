@extends('layouts.app')

@section('content')

        <div class="d-flex">

            {{-- Колонка 1 --}}

            <div class="col">

                <div class="card border-primary mb-3">
                    <div class="card-header">
                        Данные
                    </div>
                    <div class="card-body">
                        @component('components.forms.form',['url'=>route('e.users.update', $user->id), 'id'=>'form', 'method'=>'put'])

                            {{-- Имя --}}

                            @component('components.forms.plain.input',[
                                'label' => 'Имя',
                                'name' => 'name',
                                'value' => $user->name,
                                'required' => true,
                            ])@endcomponent

                            <div class="d-flex">

                                <div class="w-50 mr-2">
                                    {{-- Тип пользователя --}}

                                    @component('components.forms.plain.select',['label'=>'Тип пользователя','name'=>'type','required' => true,])
                                        @include('components.forms.elements.options',['options'=>[
                                            ['label'=>'Контрагент', 'value'=>'C', 'selected'=>$user->type == 'C' ? true : null],
                                            ['label'=>'Сотрудник', 'value'=>'E', 'selected'=>$user->type == 'E' ? true : null]
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
                                        'checked' => $user->is_admin ? true : null
                                    ])
                                </div>
                            </div>
                            {{-- Комментарий --}}

                            @component('components.forms.plain.textarea',[
                                'label' => 'Комментарий',
                                'name' => 'comment',
                                'value' => $user->comment,
                                'attr' => ['rows'=>2],
                                'help' => 'Служебная информация, которую видят только сотрудники'
                            ])@endcomponent

                            <div class="text-center">
                                @include('components.forms.elements.button',['text'=>'Сохранить'])
                            </div>
                        @endcomponent
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
                        @component('components.forms.form',['url'=>route('e.users.account', $user->id), 'id'=>'form', 'method'=>'put'])
                            {{-- Email --}}

                            @component('components.forms.plain.input',[
                                'type' => 'email',
                                'label' => 'Эл.адрес',
                                'name' => 'email',
                                'value' => $user->email,
                                'required' => true,
                                'help' => 'Будет использоваться как логин при авторизации пользователя'
                            ])@endcomponent

                            {{-- Password --}}

                            @include('components.forms.plain.preset.password_inline', ['generator'=>true, 'generator_mini'=>true, 'required'=>false])

                            <div class="text-center">
                                @include('components.forms.elements.button',['text'=>'Сохранить'])
                            </div>

                        @endcomponent
                    </div>
                </div>

            </div>

        </div>

@endsection

{{-- Правый блок --}}

@section('r_side')


@endsection
