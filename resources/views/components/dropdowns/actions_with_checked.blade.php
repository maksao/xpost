{{--
    v.1.0 (непонятно надо или нет)
--}}
<div class="dropdown" style="max-width: 40px;">
    {{--<input type="checkbox" data-action="check-all">--}}
    @component('components.forms.elements.checkbox',['id'=> $id ?? 'check-all', 'attr'=>['data-action'=>'check-all']])@endcomponent
    @isset($dropdown)
        <span class="clickable" data-toggle="dropdown"><i class="fa fa-caret-down"></i></span>
        <div class="dropdown-menu dropdown-menu-{{ $menu_align ?? 'left' }}">
            <div class="dropdown-header">Отметить :</div>
            @component('components.dropdowns.link',[
                 'title'=>'Все',
                 'attr'=>[
                     'data-toggle'=>'check-rows-all',
                     'data-check'=>'all'
                 ]
            ])@endcomponent
            @component('components.dropdowns.link',[
                'title'=>'Ни одного',
                'attr'=>[
                    'data-toggle'=>'check-rows-all',
                    'data-check'=>'none'
                ]
            ])@endcomponent
            {{ $slot }}
        </div>
    @endisset
</div>