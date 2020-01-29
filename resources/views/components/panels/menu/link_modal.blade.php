{{--

    v.1.0

--}}
@include('components.panels.menu.link',array_merge(get_defined_vars()['__data'], ['attr'=>[
    'data-toggle' => 'modal',
    'data-target' => '#'.($id ?? '')
]]))