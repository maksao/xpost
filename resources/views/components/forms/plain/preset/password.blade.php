{{--
    v.1.0
--}}
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
                    <i class="fas fa-dice"></i><span class="d-none d-md-inline-block ml-2">Придумать</span>
                </button>
            </div>
        @endisset
    </div>
@endcomponent
@isset($confirm)
    @component( 'components.forms.plain.wrapper', ['label'=>'Пароль еще раз', 'required'=>(isset($required) && $required === false) ? null : 'true'] )
        @include('components.forms.elements.input', [
            'type'=>isset($generator) ? 'text' : 'password',
            'id'=>'password-confirm',
            'name' => ($name ?? 'password').'_confirmation',
            'required'=>(isset($required) && $required === false) ? null : 'true'
        ])
    @endcomponent
@endisset
