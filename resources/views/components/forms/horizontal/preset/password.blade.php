@component( 'components.forms.horizontal.wrapper', array_merge(get_defined_vars()['__data'], ['label'=>'Пароль', 'required'=>'true', 'name'=>$name ?? 'password']) )
    @include('components.forms.elements.input', [
        'type'=>'password',
        'id'=>'password',
        'name' => $name ?? 'password',
        'required'=>'true'
    ])
    @isset($generator)
        @slot('after')
            <div class="col-2">
                <button type="button" class="btn btn-primary btn-block" data-toggle="generate-password">Придумать</button>
            </div>
        @endslot
    @endisset
@endcomponent
@isset($confirm)
    @component( 'components.forms.horizontal.wrapper', ['label'=>'Пароль еще раз', 'required'=>'true'] )
        @include('components.forms.elements.input', [
            'type'=>'password',
            'id'=>'password-confirm',
            'name' => ($name ?? 'password').'_confirmation',
            'required'=>'true'
        ])
    @endcomponent
@endisset
