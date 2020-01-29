{{--
    v.1.1
--}}
<div class="d-flex">
    <div class="flex-fill mr-1">
        @component( 'components.forms.plain.wrapper', array_merge(get_defined_vars()['__data'], [
            'label'=>'Пароль',
            'required'=>(isset($required) && $required === false) ? null : 'true',
            'name'=>$name ?? 'password'])
        )
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1">
                    @include('components.forms.elements.input', [
                        'type'=>isset($generator) ? 'text' : 'password',
                        'id'=>'password',
                        'name' => $name ?? 'password',
                        'required'=>(isset($required) && $required === false) ? null : 'true'
                    ])
                </div>
                @isset($generator)
                    <div class="ml-1">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="generate-password">
                            <i class="fas fa-dice"></i>@if(!isset($generator_mini))<span class="d-none d-md-inline-block ml-2">Придумать</span>@endif
                        </button>
                    </div>
                @endisset
            </div>
        @endcomponent
    </div>
    <div class="flex-fill">
        @component( 'components.forms.plain.wrapper', ['label'=>'Пароль еще раз', 'required'=>(isset($required) && $required === false) ? null : 'true'] )
            @include('components.forms.elements.input', [
                'type'=>isset($generator) ? 'text' : 'password',
                'id'=>'password-confirm',
                'name' => ($name ?? 'password').'_confirmation',
                'required'=>(isset($required) && $required === false) ? null : 'true'
            ])
        @endcomponent
    </div>
</div>
